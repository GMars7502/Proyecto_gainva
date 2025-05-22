<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Insumos;
use App\Models\Karness;
use App\Models\MovimientoAlmacen; // Asegúrate de que este modelo exista
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
// NOTA: Si tienes un modelo llamado 'Movimiento' (sin 'Almacen'),
// y lo usas en showMovimiento, storeMovimiento, updateMovimiento y destroy,
// necesitarás importar también: use App\Models\Movimiento;
// Actualmente, tu código usa 'Movimiento' pero importa 'MovimientoAlmacen'.
// Esto podría ser un error de lógica en tu código, pero no causará el error 'Undefined type' del controlador.

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
        $movimiento = MovimientoAlmacen::find($movimientoId); // Asegúrate de que 'Movimiento' sea 'MovimientoAlmacen' si ese es tu modelo

        if (!$movimiento) {
            return response()->json(['message' => 'Movimiento no encontrado'], 404);
        }

        // Podrías querer cargar relaciones aquí si es necesario, ej:
        // $movimiento->load('insumo', 'usuario');

        return response()->json($movimiento);
    }

    public function storeMovimiento(Request $request)
    {
        // --- Validación ---
        $validator = Validator::make($request->all(), [
            'insumo_id' => 'required|exists:insumos,id', // Asegura que el insumo exista
            'almacen' => 'required|string|max:100',
            'fecha' => 'required|date',
            'tipo_movimiento' => 'required|in:entrada,salida',
            'cant_movida' => 'required|numeric|min:0', // O min:1 si no se permiten 0
            'lote' => 'nullable|string|max:100',
            'observacion' => 'nullable|string|max:255',
            // Añade otros campos necesarios (ej: proveedor_id, etc.)
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // --- Creación ---
        // DB::beginTransaction(); // Considera usar transacciones si actualizas stock complejo
        try {
            $movimiento = MovimientoAlmacen::create($validator->validated()); // Asegúrate de que 'Movimiento' sea 'MovimientoAlmacen'

            // --- Recalcular Stock (Opcional - Simplificado) ---
            // La versión simple es NO recalcular aquí, sino dejar que la
            // siguiente llamada a getMovimientos lo haga. Si necesitas
            // recálculo inmediato, sería más complejo.

            // DB::commit(); // Si usaste transacción

            // Devolver el movimiento creado o un mensaje de éxito
            return response()->json($movimiento, 201); // 201 Created

        } catch (\Exception $e) {
            // DB::rollBack(); // Si usaste transacción
            return response()->json(['message' => 'Error al crear el movimiento', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateMovimiento(Request $request, $movimientoId)
    {
        $movimiento = MovimientoAlmacen::find($movimientoId); // Asegúrate de que 'Movimiento' sea 'MovimientoAlmacen'
        if (!$movimiento) {
            return response()->json(['message' => 'Movimiento no encontrado'], 404);
        }

        // --- Validación (similar a store, pero adaptada para update) ---
        $validator = Validator::make($request->all(), [
            'insumo_id' => 'required|exists:insumos,id',
            'almacen' => 'required|string|max:100',
            'fecha' => 'required|date',
            'tipo_movimiento' => 'required|in:entrada,salida',
            'cant_movida' => 'required|numeric|min:0',
            'lote' => 'nullable|string|max:100',
            'observacion' => 'nullable|string|max:255',
            // Otros campos...
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // --- Actualización ---
        // DB::beginTransaction();
        try {
            $movimiento->update($validator->validated());

            // --- Recalcular Stock (Opcional - Simplificado) ---

            // DB::commit();

            return response()->json($movimiento); // Devuelve el movimiento actualizado

        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['message' => 'Error al actualizar el movimiento', 'error' => $e->getMessage()], 500);
        }
    }


    public function listKarness($insumoId, $almacen){
        // Este método parece ser parte de un Livewire component o una lógica diferente,
        // ya que usa $this->insumoId y $this->almacen.
        // En un controlador HTTP normal, se accedería a ellos vía Request o parámetros de ruta.
        // Si este método es llamado desde una ruta, $insumoId y $almacen ya son parámetros de la función.
        // Si es un Livewire, entonces este código debería estar en un componente Livewire, no en un controlador HTTP.

        $insumoActual = Insumos::find($insumoId); // Usar el parámetro de la función
        if (!$insumoActual) {
            Log::warning("Insumo con ID {$insumoId} no encontrado en cargarInsumos.");
            // Si esto fuera un Livewire, se manejarían propiedades. En un controlador, se retorna una respuesta.
            return response()->json(['message' => "Insumo con ID {$insumoId} no encontrado."], 404);
        }
        $karnessId = $insumoActual->idKarness; // Asumiendo que idKarness es una propiedad del modelo Insumos

        $query = Insumos::where('idKarness', $karnessId);

        if ($almacen === 'Principal') { // Usar el parámetro de la función
            $query->where('almacenPrincipal', 'Y');
        } elseif ($almacen === 'Secundario') { // Usar el parámetro de la función
            $query->where('almacenSegundo', 'Y');
        }

        $insumos = $query->orderBy('idInsumo')->get()->values();

        // En un controlador, no se suelen establecer propiedades $this->insumos o $this->indiceActual
        // Se retornarían los datos necesarios para la vista.
        return response()->json([
            'insumos' => $insumos,
            'karnessId' => $karnessId,
            // 'indiceActual' => $indice, // Si necesitas calcularlo y devolverlo
        ]);
    }


    public function destroy(string $id)
    {
        try {
            $movimiento = MovimientoAlmacen::findOrFail($id); // Asegúrate de que 'Movimiento' sea 'MovimientoAlmacen'

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