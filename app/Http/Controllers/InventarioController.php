<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inventario;
use App\Models\Insumos;
use App\Models\Almacen;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $fecha_actual = Carbon::now();
        $year_actual = $fecha_actual->year;
        $month_actual = $fecha_actual->month;

        // 1. Agrupar y sumar cant_stock por idInsumo
        $stockPorInsumo = Almacen::select('idInsumo', DB::raw('SUM(cant_stock) as total_stock'))
            ->whereYear('fecha_guardado', $year_actual)
            ->whereMonth('fecha_guardado', $month_actual)
            ->groupBy('idInsumo')
            ->pluck('total_stock', 'idInsumo'); // Esto crea un array: [idInsumo => total_stock]

        // 2. Obtener todos los insumos del inventario (con nombre si hay relación)
        $data = Inventario::with('insumos')->get()->map(function ($item) use ($stockPorInsumo) {
            return [
                'idInsumo'       => $item->idInsumo,
                'Nombre'         => $item->insumos->Nombre ?? 'Sin nombre',
                'cant_atencion'  =>  $item->cant_atencion,
                'stock'  => $stockPorInsumo[$item->idInsumo] ?? 0,
                'tipo_cantidad'  => $item->tipo_cantidad,
            ];
        });

        return view('inventario.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
