<?php

namespace App\Http\Controllers;

use App\Models\Petitorio;
use Illuminate\Http\Request;
use App\Models\Insumos;

use Carbon\Carbon;
use App\Models\Inventario;
use App\Models\Almacen;
use App\Services\MovimientoService;
use Illuminate\Support\Facades\DB;

class PetitorioController extends Controller
{


    protected $movimientoService;

    public function __construct(MovimientoService $movimientoService)
    {
        $this->movimientoService = $movimientoService;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $listPetitorio = Petitorio::all();


        return view('petitorio.index', compact('listPetitorio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //$listInsumos = Insumos::all();


        $fecha_actual = Carbon::now();
        $year_actual = $fecha_actual->year;
        $month_actual = $fecha_actual->month;

        // 1. Agrupar y sumar cant_stock por idInsumo
        $stockPorInsumo = Almacen::select('idInsumo', DB::raw('SUM(cant_stock) as total_stock'))
            ->whereYear('fecha_guardado', $year_actual)
            ->whereMonth('fecha_guardado', $month_actual)
            ->where('zona','PRINCIPAL')
            ->groupBy('idInsumo')
            ->pluck('total_stock', 'idInsumo');

        // 2. Obtener todos los insumos del inventario (con nombre si hay relación)
        $listInsumos = Inventario::with('insumos')->get()->map(function ($item) use ($stockPorInsumo) {
            return [
                'idInsumo'       => $item->idInsumo,
                'Nombre'         => $item->insumos->Nombre ?? 'Sin nombre',
                'cant_atencion'  =>  $item->cant_atencion,
                'stock'  => $stockPorInsumo[$item->idInsumo] ?? 0,
                'tipo_cantidad'  => $item->tipo_cantidad,
                'control_cebado' => $item->insumos->control_cebado ?? 'No definido',
            ];
        });



        return view('petitorio.create', compact('listInsumos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            try {
            // Validar los datos del request
            $request->validate([
                'fecha_servicio' => 'required|date',
                'insumos_cant' => 'required|string',
                'status_proceso' => 'required|string|max:10',
                'status_confirmacion' => 'required|string|max:1',
                'observacion' => 'nullable|string|max:255',
            ]);

            $fecha_actual = Carbon::now();

            $petitorio = Petitorio::create([
                'fecha_servicio' => $request->fecha_servicio,
                'fecha_creado' => $fecha_actual,
                'insumos_cant' => $request->insumos_cant,
                'status_proceso' => $request->status_proceso,
                'status_confirmacion' => $request->status_confirmacion,
                'observacion' => $request->observacion,
            ]);

            // Return a JSON response for success
            return response()->json([
                'message' => 'Petitorio guardado exitosamente.',
                'petitorio' => $petitorio, // Optionally return the created model
                'status' => 200
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's default handling for validation errors is usually sufficient,
            // but if you want to customize the response, you can catch it explicitly.
            // By default, it returns a 422 Unprocessable Entity with JSON errors.
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el petitorio: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Petitorio $petitorio)
    {
        
        $petitorio = Petitorio::findOrFail($petitorio->idpetitorio);

        
        $almacenNombre = 'principal';

        $insumosControladosIds = Insumos::where('control_cebado', 'Y')->pluck('idInsumo')->toArray();

        // If no controlled insumos are found, there's no stock to fetch
        if (empty($insumosControladosIds)) {
            Log::info("No insumos found with 'control_cebado' = 'Y'.");
            return view('petitorio.show', compact('petitorio'))->with('lotesConCantidadesPorInsumo', []);
        }

        // Define the current period (start of the current month)
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $periodoActual = Carbon::create($year, $month, 1)->startOfMonth();




        $lotesConCantidades = Almacen::whereIn('idInsumo', $insumosControladosIds)
            ->where('zona', $almacenNombre)
            ->where('fecha_guardado', $periodoActual)
            ->get([
                'idInsumo',
                'lote',
                'cant_stock'
            ]);

        $lotesConCantidadesPorInsumo = [];
        foreach ($lotesConCantidades as $item) {
            $lotesConCantidadesPorInsumo[$item->idInsumo][] = [
                'lote' => $item->lote,
                'cantidad' => $item->cant_stock,
            ];
        }




        return view('petitorio.show', compact('petitorio','lotesConCantidadesPorInsumo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petitorio $petitorio)
    {
        
        
        $petitorio = Petitorio::findOrFail($petitorio->idpetitorio);

        
        $almacenNombre = 'principal';

        $insumosControladosIds = Insumos::where('control_cebado', 'Y')->pluck('idInsumo')->toArray();

        // If no controlled insumos are found, there's no stock to fetch
        if (empty($insumosControladosIds)) {
            Log::info("No insumos found with 'control_cebado' = 'Y'.");
            return view('petitorio.edit', compact('petitorio'))->with('lotesConCantidadesPorInsumo', []);
        }

        // Define the current period (start of the current month)
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $periodoActual = Carbon::create($year, $month, 1)->startOfMonth();




        $lotesConCantidades = Almacen::whereIn('idInsumo', $insumosControladosIds)
            ->where('zona', $almacenNombre)
            ->where('fecha_guardado', $periodoActual)
            ->get([
                'idInsumo',
                'lote',
                'cant_stock'
            ]);

        $lotesConCantidadesPorInsumo = [];
        foreach ($lotesConCantidades as $item) {
            $lotesConCantidadesPorInsumo[$item->idInsumo][] = [
                'lote' => $item->lote,
                'cantidad' => $item->cant_stock,
            ];
        }




        return view('petitorio.edit', compact('petitorio','lotesConCantidadesPorInsumo'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Petitorio $petitorio)
    {
        $validated = $request->validate([
            'fecha_servicio' => 'required|date',
            'status_proceso' => 'required|string|in:borrador,rectificado,confirmado,cancelado',
            'status_confirmacion' => 'nullable|string|max:10',
            'observacion' => 'nullable|string|max:1000',
            'insumos_cant' => 'required|string',
        ]);

        try {
            switch ($validated['status_proceso']) {
                case 'rectificado':
                    $insumos_cant_decoded = json_decode($validated['insumos_cant'], true);
                    if (!is_array($insumos_cant_decoded)) {
                        return response()->json(['message' => 'El campo insumos_cant no es un JSON válido.'], 422);
                    }

                    $petitorio->update([
                        'fecha_servicio' => $validated['fecha_servicio'],
                        'status_proceso' => $validated['status_proceso'],
                        'status_confirmacion' => $validated['status_confirmacion'],
                        'observacion' => $validated['observacion'],
                        'insumos_cant' => json_encode($insumos_cant_decoded),
                    ]);

                    return response()->json(['message' => 'Petitorio actualizado correctamente.']);
                    break;

                case 'confirmado':
                    $insumos_cant_decoded = json_decode($validated['insumos_cant'], true);
                    if (!is_array($insumos_cant_decoded)) {
                        return response()->json(['message' => 'El campo insumos_cant no es un JSON válido.'], 422);
                    }

                    $fecha_actual = Carbon::now();
                    $observacion = $fecha_actual->format('Y-m-d') . ' (I-II-III)';
                    $almacenNombre = 'principal';

                    foreach ($insumos_cant_decoded as $item) {
                        $insumoId = $item['idProducto'] ?? null;
                        if (!$insumoId || empty($item['cantidad_salida']) || $item['cantidad_salida'] <= 0) {
                            continue;
                        }

                        $movimientos_guardar = [];

                        if (($item['control_lote'] ?? 'N') === 'Y') {
                            $movimiento_lote = $item['lotes_asignados'] ?? null;
                            if (!is_array($movimiento_lote)) {
                                return response()->json(['message' => 'El campo lotes_asignados debe ser un arreglo para los insumos con control de lote.'], 422);
                            }

                            foreach ($movimiento_lote as $value) {
                                if (!isset($value['lote']) || !isset($value['cantidad'])) {
                                    return response()->json(['message' => 'El campo lote y cantidad son obligatorios.'], 422);
                                }

                                $movimientos_guardar[] = [
                                    'cant_movida' => $value['cantidad'],
                                    'tipo_movimiento' => 'salida',
                                    'fecha' => $fecha_actual->format('Y-m-d'),
                                    'observacion' => $observacion,
                                    'lote' => $value['lote'],
                                ];
                            }
                        } else {
                            $movimientos_guardar[] = [
                                'cant_movida' => $item['cantidad_salida'],
                                'tipo_movimiento' => 'salida',
                                'fecha' => $fecha_actual->format('Y-m-d'),
                                'observacion' => $observacion,
                                'lote' => null,
                            ];
                        }
                        $this->movimientoService->registrarNuevosMovimientos(
                            $movimientos_guardar,
                            $insumoId,
                            $almacenNombre
                        );
                    }

                    // Si deseas también actualizar el petitorio en estado "confirmado":
                    $petitorio->update([
                        'fecha_servicio' => $validated['fecha_servicio'],
                        'status_proceso' => $validated['status_proceso'],
                        'status_confirmacion' => 'Y',
                        'observacion' => $validated['observacion'],
                        'insumos_cant' => json_encode($insumos_cant_decoded),
                    ]);

                    return response()->json(['message' => 'Petitorio confirmado y movimientos registrados.']);
                    break;

                case 'cancelado':

                    $insumos_cant_decoded = json_decode($validated['insumos_cant'], true);
                    if (!is_array($insumos_cant_decoded)) {
                        return response()->json(['message' => 'El campo insumos_cant no es un JSON válido.'], 422);
                    }

                    $petitorio->update([
                        'fecha_servicio' => $validated['fecha_servicio'],
                        'status_proceso' => $validated['status_proceso'],
                        'status_confirmacion' => $validated['status_confirmacion'],
                        'observacion' => $validated['observacion'],
                        'insumos_cant' => json_encode($insumos_cant_decoded),
                    ]);

                    return response()->json(['message' => 'Petitorio actualizado correctamente.']);
                    break;

                    
                    break;



                default:
                    return response()->json(['message' => 'Estado no soportado.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el petitorio: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petitorio $petitorio)
    {
        try {
         $petitorio = Petitorio::findOrFail($petitorio->idpetitorio);

        // Eliminar el petitorio
        if(!$petitorio){
             return redirect()->back()->with('error', 'No se pudo encontrar el petitorio.');
            
        }

        if($petitorio->status_proceso == 'confirmado'){

            return redirect()->back()->with('error', 'No se puede eliminar un petitorio confirmado.');


        }

        $petitorio->delete();



         return redirect()->back()->with('success', 'Se eliminó el petitorio exitosamente.');


    } catch (\Exception $e) {

        return redirect()->back()->with('error', 'No se pudo eliminar: ' . $e->getMessage());

     
    }}
}
