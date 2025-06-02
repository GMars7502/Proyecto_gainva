<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Almacen;
use App\Models\Insumos;
use App\Models\Karness;

use App\Models\MovimientoAlmacen;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use App\Services\MovimientoService; // <--- Importa tu servicio
use App\Http\Requests\GetMovimientosRequest; // <--- Ejemplo de Form Request (ver punto 2)
use App\Http\Requests\StoreMovimientoRequest;

class MovimientoController extends Controller
{

    protected $movimientoService;

    public function __construct(MovimientoService $movimientoService)
    {
        $this->movimientoService = $movimientoService;
    }


    public function getMovimientos(Request $request, $insumoId)
    {
       $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2000|max:' . (now()->year + 5),
            'month' => 'required|integer|min:1|max:12',
            'almacen' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            Log::warning('[getMovimientos] Validación fallida:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $year = $request->input('year');
        $month = $request->input('month');
        $almacenNombre = $request->input('almacen');

        $periodoSolicitado = Carbon::create($year, $month, 1)->startOfMonth();
        Log::info("[getMovimientos] Solicitud para InsumoID: {$insumoId}, Almacen: {$almacenNombre}, Periodo Solicitado: {$periodoSolicitado->toDateString()}");

        $stockPorLoteActual = Almacen::where('idInsumo', $insumoId)
            ->where('zona', $almacenNombre)
            ->where('fecha_guardado', $periodoSolicitado) // Compara con la columna 'periodo'
            ->get();


        // 2. Si no hay stock para el período solicitado, intentar arrastrar del anterior
        if ($periodoSolicitado->equalTo(Carbon::now()->startOfMonth())) { 
        
            if ($stockPorLoteActual->isEmpty()) {
                Log::info("[getMovimientos] No se encontró stock para el periodo solicitado. Intentando arrastre...");

                $periodoFuenteParaArrastre = null;

                // Buscar último registro en el mismo año, meses anteriores
                $ultimoRegistroMismoAno = Almacen::where('idInsumo', $insumoId)
                    ->where('zona', $almacenNombre)
                    ->where('fecha_guardado', '<', $periodoSolicitado) // Periodos anteriores al solicitado
                    ->whereYear('fecha_guardado', $year)           // Dentro del mismo año solicitado
                    ->orderBy('fecha_guardado', 'desc')            // El más reciente
                    ->first();

                if ($ultimoRegistroMismoAno) {
                    $periodoFuenteParaArrastre = Carbon::parse($ultimoRegistroMismoAno->fecha_guardado)->startOfMonth();
                    Log::info("[getMovimientos] Periodo fuente para arrastre encontrado en el mismo año: {$periodoFuenteParaArrastre->toDateString()}");
                } else {
                    // Si no hay en el mismo año, buscar último registro del año anterior
                    $ultimoRegistroAnoAnterior = Almacen::where('idInsumo', $insumoId)
                        ->where('zona', $almacenNombre)
                        ->whereYear('fecha_guardado', $year - 1) // Del año anterior
                        ->orderBy('fecha_guardado', 'desc')     // El mes más reciente de ese año anterior
                        ->first();

                    if ($ultimoRegistroAnoAnterior) {
                        $periodoFuenteParaArrastre = Carbon::parse($ultimoRegistroAnoAnterior->fecha_guardado)->startOfMonth();
                        Log::info("[getMovimientos] Periodo fuente para arrastre encontrado en año anterior: {$periodoFuenteParaArrastre->toDateString()}");
                    }
                }

                // Si encontramos un período fuente, arrastramos los datos
                if ($periodoFuenteParaArrastre) {
                    $stockParaArrastrar = Almacen::where('idInsumo', $insumoId)
                        ->where('zona', $almacenNombre)
                        ->where('fecha_guardado', $periodoFuenteParaArrastre)
                        ->get();

                    if ($stockParaArrastrar->isNotEmpty()) {
                        Log::info("[getMovimientos] Arrastrando " . $stockParaArrastrar->count() . " registros de lote desde {$periodoFuenteParaArrastre->toDateString()} hacia {$periodoSolicitado->toDateString()}");
                        DB::transaction(function () use ($stockParaArrastrar, $insumoId, $almacenNombre, $periodoSolicitado) {
                            foreach ($stockParaArrastrar as $itemStockAnterior) {
                                // Usar updateOrCreate para evitar duplicados si esta lógica se ejecuta múltiples veces
                                // y para asegurar que solo se actualice el stock si ya existe un placeholder.
                                Almacen::updateOrCreate(
                                    [ // Atributos para buscar el registro
                                        'idInsumo'       => $insumoId,
                                        'zona'            => $almacenNombre,
                                        'lote'            => $itemStockAnterior->lote, // Arrastrar el lote
                                        'fecha_guardado'         => $periodoSolicitado,      // Para el NUEVO período
                                    ],
                                    [ // Valores para establecer/actualizar
                                        'cant_stock' => $itemStockAnterior->cant_stock, // Arrastrar el stock
                                        // Otros campos de tu tabla Almacen que necesiten valor por defecto al crear
                                    ]
                                );
                            }
                        });
                        // Después de crear, re-consultamos para obtener los datos del período solicitado
                        $stockPorLoteActual = Almacen::where('idInsumo', $insumoId)
                            ->where('zona', $almacenNombre)
                            ->where('fecha_guardado', $periodoSolicitado)
                            ->get();
                        Log::info("[getMovimientos] Stock después del arrastre para el periodo solicitado:", $stockPorLoteActual->toArray());
                    } else {
                        Log::info("[getMovimientos] No hay datos de stock en el período fuente ({$periodoFuenteParaArrastre->toDateString()}) para arrastrar.");
                    }
                } else {
                    Log::info("[getMovimientos] No se encontró ningún período fuente para el arrastre de stock.");
                }
            }
        }

        // 3. Obtener Movimientos del Mes (para el período solicitado)
        $movimientos = MovimientoAlmacen::where('fk_insumos', $insumoId) // Ajusta 'fk_insumos' si es diferente
                                ->where('almacen', $almacenNombre)
                                ->whereYear('fecha', $year)
                                ->whereMonth('fecha', $month)
                                ->orderBy('fecha', 'asc')
                                ->orderBy('idMovimiento', 'asc') // Ajusta 'idMovimiento' si es diferente
                                ->get();
        Log::info("[getMovimientos] Movimientos del mes encontrados:", $movimientos->toArray());

        return response()->json([
            'movimientos' => $movimientos,
            'stockPorLote' => $stockPorLoteActual // Esta variable ahora SIEMPRE contiene el stock del período solicitado
        ]);

    }




    public function getNavegacion(Request $request, $insumoId)
    {
        $almacen = $request->input('almacen'); // Recibe el almacén si es necesario para filtrar

        // Asumiremos que los insumos se ordenan por Nombre para la navegación
        // TODO: Adaptar si los insumos dependen del almacén o si hay otro criterio
        $orden = 'Nombre'; // Criterio de ordenación

        $insumoActual = Insumos::find($insumoId);
        if (!$insumoActual) {
             return response()->json(['message' => 'Insumo actual no encontrado'], 404);
        }

        // Insumo Anterior
        $insumoAnterior = Insumos::where($orden, '<', $insumoActual->$orden)
                                // ->where('almacen', $almacen) // Descomentar si aplica
                                ->orderBy($orden, 'desc')
                                ->first(['idInsumo', 'Nombre']); // Solo los campos necesarios

        // Insumo Siguiente
        $insumoSiguiente = Insumos::where($orden, '>', $insumoActual->$orden)
                                 // ->where('almacen', $almacen) // Descomentar si aplica
                                 ->orderBy($orden, 'asc')
                                 ->first(['idInsumo', 'Nombre']); // Solo los campos necesarios


        return response()->json([
            'actual' => $insumoActual, // Devolvemos también el actual por si acaso
            'anterior' => $insumoAnterior,
            'siguiente' => $insumoSiguiente,
        ]);
    }

    public function showMovimiento($movimientoId)
    {
        $movimiento = Movimiento::find($movimientoId);

        if (!$movimiento) {
            return response()->json(['message' => 'Movimiento no encontrado'], 404);
        }

        // Podrías querer cargar relaciones aquí si es necesario, ej:
        // $movimiento->load('insumo', 'usuario');

        return response()->json($movimiento);
    }

    public function storeMovimiento(Request $request)
    {
        Log::info('Entrado al metodo storeMovimiento 1.');
        // Validación básica del payload general (podría ir en un FormRequest)
        $validadorGeneral = Validator::make($request->all(), [
            'idInsumo' => 'required|integer|exists:insumos', // Asegúrate que 'idInsumo' sea tu PK
            'almacen' => 'required|string|max:100',
            'movimientos' => 'required|array|min:1',
            // Validar que cada item en 'movimientos' tenga 'tipo_movimiento'
            'movimientos.*.tipo_movimiento' => 'required|in:entrada,salida'
        ]);
        

        if ($validadorGeneral->fails()) {
            Log::info('Fallo la validacion general', ['errors' => $validadorGeneral->errors()]);
            return response()->json([
                'message' => 'Datos generales de la solicitud inválidos.',
                'errors' => $validadorGeneral->errors()
            ], 422);
        }


        Log::info('Se entrar al try de la validacion general');

        $insumoId = $request->input('idInsumo');
        $almacenNombre = $request->input('almacen');
        $movimientosData = $request->input('movimientos');

        try {

            Log::info('Antes de entrar al registarNuevosMovimietnos ');
            $idsMovimientosCreados = $this->movimientoService->registrarNuevosMovimientos(
                $movimientosData,
                $insumoId,
                $almacenNombre
            );


            return response()->json([
                'message' => count($idsMovimientosCreados) . ' movimiento(s) guardado(s) con éxito.',
                'data' => ['ids_creados' => $idsMovimientosCreados]
            ], 201);

        } catch (CustomValidationException $e) { // Captura tu excepción personalizada
            Log::warning("[MovimientoController@store] Errores de validación del servicio: " . $e->getMessage(), $e->getErrors());
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->getErrors()
            ], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            Log::error("[MovimientoController@store] Excepción general: " . $e->getMessage());
            return response()->json([
                'message' => 'Error interno al procesar la solicitud.',
                'error_detail' => $e->getMessage() // No envíes e->getTraceAsString() a producción
            ], 500);
        }
    }

    public function updateMovimiento(Request $request, $movimientoId)
    {
        $datosParaActualizar = $request->all();

        $validadorPayload = Validator::make($datosParaActualizar, [
            'fecha' => 'sometimes|required|date_format:Y-m-d',
            'cant_movida' => 'sometimes|required|integer|min:1',
        ]);
        if ($validadorPayload->fails()){
            return response()->json(['message' => 'Payload inválido.', 'errors' => $validadorPayload->errors()], 422);
        }


        try {
            $movimientoActualizado = $this->movimientoService->actualizarUnMovimiento(
                (int)$movimientoId,
                $datosParaActualizar
            );
            return response()->json([
                'message' => 'Movimiento actualizado con éxito.',
                'data' => $movimientoActualizado
            ], 200);

        } catch (CustomValidationException $e) {
            Log::warning("[MovimientoController@update] Error de validación del servicio para Mov ID {$movimientoId}: " . $e->getMessage(), $e->getErrors());
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->getErrors()], 422);
        } catch (\Exception $e) {
            Log::error("[MovimientoController@update] Excepción general para Mov ID {$movimientoId}: " . $e->getMessage());
            return response()->json([
                'message' => 'Error interno al actualizar el movimiento.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }




    public function listKarness($insumoId, $almacen){

        $insumoActual = Insumos::find($this->insumoId);
        if (!$insumoActual) {
            Log::warning("Insumo con ID {$this->insumoId} no encontrado en cargarInsumos.");
            $this->insumos = collect();
            $this->karness = null;
            $this->indiceActual = 0;
            return;
        }
        $this->karness = $insumoActual->idKarness;

        $query = Insumos::where('idKarness', $this->karness);

        if ($this->almacen === 'Principal') {
            $query->where('almacenPrincipal', 'Y');
        } elseif ($this->almacen === 'Secundario') {
            $query->where('almacenSegundo', 'Y');
        }

        $this->insumos = $query->orderBy('idInsumo')->get()->values();

        $indice = $this->insumos->search(fn($i) => $i->idInsumo == $this->insumoId);
        $this->indiceActual = ($indice !== false) ? $indice : 0;
    }



    public function destroy(string $movimientoId)
    {
        Log::info("[MovimientoController@destroy] Solicitud para eliminar Movimiento ID: {$movimientoId}");
        try {
            $this->movimientoService->eliminarUnMovimiento((int)$movimientoId); // Llama al servicio

            return response()->json(['message' => 'Movimiento eliminado con éxito.'], 200);

        } catch (CustomValidationException $e) {
            Log::warning("[MovimientoController@destroy] Error de validación del servicio para Mov ID {$movimientoId}: " . $e->getMessage(), $e->getErrors());
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->getErrors()], 422); // Unprocessable Entity
        } catch (ModelNotFoundException $e) {
            Log::warning("[MovimientoController@destroy] Movimiento ID {$movimientoId} no encontrado por el servicio.");
            return response()->json(['message' => 'Movimiento no encontrado para eliminar.'], 404); // Not Found
        } catch (\Exception $e) {
            Log::error("[MovimientoController@destroy] Excepción general para Mov ID {$movimientoId}: " . $e->getMessage());
            return response()->json([
                'message' => 'Error interno al eliminar el movimiento.',
                'error_detail' => $e->getMessage() // En desarrollo, podrías enviar más detalles
            ], 500); // Internal Server Error
        }
    
    }
}
