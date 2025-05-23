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


class MovimientoController extends Controller
{
    public function getMovimientos(Request $request, $insumoId)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'month' => 'required|integer|min:1|max:12',
            //'almacen' => 'required|string|max:100', // pARA AGREGAR FILTRO ALMACEN corresponda
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Unprocessable Entity
        }

        $year = $request->input('year');
        $month = $request->input('month');
        //$almacen = $request->input('almacen'); PARA AGREGAR FILTRO POR ALMACEN


        //$fechaInicio = Carbon::create($year, $month, 1)->startOfMonth();
        //$fechaFin = Carbon::create($year, $month, 1)->endOfMonth();

        // --- Cálculo de Stock Inicial para el Mes ---
        // Suma/resta todas las cantidades movidas ANTES del inicio del mes actual
        /*
        $stockInicial = Movimiento::where('insumo_id', $insumoId)
            ->where('almacen', $almacen) // Filtrar por almacén
            ->where('fecha', '<', $fechaInicio)
            ->selectRaw('SUM(CASE WHEN tipo_movimiento = "entrada" THEN cant_movida ELSE -cant_movida END) as balance')
            ->value('balance') ?? 0; // Si no hay movimientos previos, el stock inicial es 0

        */

        // --- Obtener Movimientos del Mes ---
        $movimientos = MovimientoAlmacen::where('fk_insumos', $insumoId)
        ->whereYear('fecha', $year)
        ->whereMonth('fecha', $month)
        ->orderBy('fecha', 'asc') // Importante ordenar cronológicamente
        ->orderBy('idMovimiento', 'asc') // Desempate por ID
        ->get();


        return response()->json($movimientos);

        // --- Calcular Stock Acumulado para cada Movimiento ---

        /*
        $stockActual = $stockInicial;
        $movimientosConStock = $movimientos->map(function ($movimiento) use (&$stockActual) {
            if ($movimiento->tipo_movimiento == 'entrada') {
                $stockActual += $movimiento->cant_movida;
            } elseif ($movimiento->tipo_movimiento == 'salida') {
                $stockActual -= $movimiento->cant_movida;
            }
            // Añadimos el stock *después* de este movimiento como un atributo
            $movimiento->stock = $stockActual;
            return $movimiento;
        });

        return response()->json($movimientosConStock);
        */
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
        $tipoOperacion = $request->input('tipo'); // 'entradas' o 'salidas'
        $insumoId = $request->input('insumo_id');
        $almacenNombre = $request->input('almacen');
        $movimientosData = $request->input('movimientos', []); // Array de movimientos

        if (empty($movimientosData)) {
            return response()->json(['message' => 'No se proporcionaron datos de movimientos.'], 400);
        }

        $insumoActual = Insumos::find($insumoId);
        if (!$insumoActual) {
            return response()->json(['message' => "Insumo con ID {$insumoId} no encontrado."], 404);
        }
        // Asume que control_cebado es 'Y' para verdadero, o 1, o true. Ajusta según tu DB.
        $loteRequerido = ($insumoActual->control_cebado === 'Y');

        $erroresDeValidacion = [];
        $movimientosGuardados = [];

        DB::beginTransaction(); // Iniciar transacción

        try {
            foreach ($movimientosData as $index => $data) {
                $reglasBase = [
                    'fecha' => 'required|date',
                    'cant_movida' => 'required|numeric|min:0.01', // No permitir 0
                    'observacion' => ($tipoOperacion === 'entradas') ? 'required|string|max:255' : 'nullable|string|max:255',
                    'lote' => $loteRequerido ? 'required|string|max:100' : 'nullable|string|max:100',
                ];

                if ($tipoOperacion === 'entradas') {
                    $reglasBase['factura_boleta'] = 'nullable|string|max:100';
                    $reglasBase['proveedor'] = 'nullable|string|max:100';
                }
                // Aquí podrías añadir más reglas específicas si las cabeceras de 'salidas' son diferentes

                $validador = Validator::make($data, $reglasBase);

                if ($validador->fails()) {
                    $erroresDeValidacion["movimiento_{$index}"] = $validador->errors();
                    continue; // Saltar este movimiento y continuar con el siguiente
                }

                // Crear el movimiento
                MovimientoAlmacen::create([ // Asegúrate que este es tu modelo y que los campos coinciden
                    'fk_insumos' => $insumoId,
                    'almacen' => $almacenNombre,
                    'tipo_movimiento' => $data['tipo_movimiento'], // 'entrada' o 'salida'
                    'fecha' => $data['fecha'],
                    'cant_movida' => $data['cant_movida'],
                    'factura_boleta' => $data['factura_boleta'] ?? null,
                    'observacion' => $data['observacion'],
                    'lote' => $data['lote'],
                    'proveedor' => $data['proveedor'] ?? null,
                    // ...otros campos que necesites: usuario_id, etc.
                ]);
                // Nota: El cálculo de stock se omitió aquí, se recalculará al llamar a fetchMovimientos.
            }

            if (!empty($erroresDeValidacion)) {
                DB::rollBack(); // Revertir si hubo errores
                return response()->json([
                    'message' => 'Algunos movimientos no pasaron la validación.',
                    'errors' => $erroresDeValidacion
                ], 422);
            }

            DB::commit(); // Confirmar transacción si todo OK
            return response()->json(['message' => 'Movimiento(s) guardado(s) con éxito.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("API [store Movimiento]: Error al guardar:", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error interno al guardar los movimientos.', 'error_detail' => $e->getMessage()], 500);
        }
    }

    public function updateMovimiento(Request $request, $movimientoId)
    {
        Log::info('Entrado al metodo updateMovimietno 1.');
        $movimiento = MovimientoAlmacen::find($movimientoId);
        if (!$movimiento) {
            Log::info('No se encontró el movimiento con su id .', ['movimientoId' => $movimientoId]);
            return response()->json(['message' => 'Movimiento no encontrado'], 404);
        }

        $insumoActual = Insumos::find($movimiento->fk_insumos); // Necesitas el insumo_id del movimiento
        $loteRequerido = false;
        if ($insumoActual && ($insumoActual->control_cebado === 'Y') && $movimiento->tipo_movimiento === 'entrada') {
            $loteRequerido = true;
        }

        $reglas = [
            'fecha' => 'required|date',
            'cant_movida' => 'required|numeric|min:0.01',
            'observacion' => ($movimiento->tipo_movimiento === 'entrada') ? 'required|string|max:255' : 'nullable|string|max:255', // Ajusta si es obligatorio para salidas también
            'lote' => $loteRequerido ? 'required|string|max:100' : 'nullable|string|max:100',
        ];

        if ($movimiento->tipo_movimiento === 'entrada') {
            $reglas['factura_boleta'] = 'nullable|string|max:100';
            $reglas['proveedor'] = 'nullable|string|max:100';
        }

        $validador = Validator::make($request->all(), $reglas);

        if ($validador->fails()) {
            return response()->json(['message' => 'Datos de entrada inválidos.', 'errors' => $validador->errors()], 422);
        }

        $datosParaActualizar = $validador->validated();


        
        // --- Actualización ---
        // DB::beginTransaction();
        try {

            Log::info('Se entro al try de la actualizacion');
            
            $movimiento->update($datosParaActualizar);
           

            Log::info('Se entro al try de la actualizacion 2');

            // --- Recalcular Stock (Opcional - Simplificado) ---

            // DB::commit();

            return response()->json(['message' => 'Movimiento actualizado con éxito.', 'movimiento' => $movimiento]);

        } catch (\Exception $e) {
            Log::info('Se vio un error en el try de la actualizacion', ['error' => $e->getMessage()]);
            // DB::rollBack();
            return response()->json(['message' => 'Error al actualizar el movimiento', 'error' => $e->getMessage()], 500);
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



    public function destroy(string $id)
    {
        try {
            $movimiento = MovimientoAlmacen::findOrFail($id);

            $movimiento->delete();

            return response()->json(['message' => 'Movimiento eliminado con éxito.'], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Movimiento no encontrado.'], 404);
        } catch (\Exception $e) {
            
            Log::error("Error al eliminar movimiento {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Error interno al eliminar el movimiento.'], 500);
        }
    
    }
}
