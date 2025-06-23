<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

USE App\Models\ControlCebado;
use App\Models\Insumos;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControlCebadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $InsumosConcontrolCebado = Insumos::where('control_cebado', 'Y')
            ->get();

        return view('control_cebado.index', compact('InsumosConcontrolCebado'));
    }

    public function table(Request $request){

        $fecha = Carbon::parse($request->input('fecha'));
        $year = $fecha->year;
        $month = $fecha->month;
        $variableprueba =$request->input('insumoid');




        $datosControlCebado = ControlCebado::whereYear('actualFecha', $year)
            ->whereMonth('actualFecha', $month)
            ->where('fk_insumos', $request->input('insumoid'))
            ->orderBy('created_at', 'desc')
            ->get();


        $prueba = "Hola que tal: {{$fecha}} i {{$variableprueba}}";

        


        return view('control_cebado.table', compact('datosControlCebado','prueba'));


    }



    public function ruleFiltrosSet(Request $request)
    {
        $fecha = Carbon::parse($request->input('fecha'));
        $year = $fecha->year;
        $month = $fecha->month;

        // Obtener los insumos con control_cebado = 'Y'
        $insumos = Insumos::where('control_cebado', 'Y')->get();

        // Obtener los totales por insumo para ese mes y año
        $totales = ControlCebado::select(
                'fk_insumos as idInsumo',
                DB::raw('SUM(COALESCE(cant1, 0) + COALESCE(cant2, 0) + COALESCE(cant3, 0) + COALESCE(cant4, 0)) as CantTotal')
            )
            ->whereYear('actualFecha', $year)
            ->whereMonth('actualFecha', $month)
            ->groupBy('fk_insumos')
            ->get()
            ->keyBy('idInsumo');

        // Combinar insumos con sus totales
        $resultado = $insumos->map(function ($insumo) use ($totales) {
            return [
                'idInsumo' => $insumo->idInsumo,
                'InsumoNombre' => $insumo->Nombre,
                'CantTotal' => $totales[$insumo->idInsumo]->CantTotal ?? 0
            ];
        });

        return response()->json($resultado);

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
