<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

USE App\Models\ControlCebado;
use App\Models\Insumos;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ControlCebadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $InsumosConcontrolCebado = Insumos::where('control_cebado', 'Y')
            ->get();

        log::info('Insumos con control de cebado: ' . $InsumosConcontrolCebado->count());


        return view('control_cebado.index', compact('InsumosConcontrolCebado'));
    }

    public function table(Request $request){

        $fecha = Carbon::parse($request->input('fecha'));
        $year = $fecha->year;
        $month = $fecha->month;




        $datosControlCebado = ControlCebado::whereYear('actualFecha', $year)
            ->whereMonth('actualFecha', $month)
            ->where('fk_insumos', $request->input('idInsumo'))
            ->orderBy('created_at', 'desc')
            ->get();


        $prueba = "Hola que tal";

        


        return view('control_cebado.table', compact('datosControlCebado','prueba'));


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
