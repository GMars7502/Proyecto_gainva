<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumos;
use Illuminate\Support\Facades\Log;

class InsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        log::info('InsumosController - Entrado a store');


        $validator = \Validator::make($request->all(), [
            'Nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'control_cebado' => 'required|string|max:1',
            'control_emergencia' => 'required|string|max:1',
            'almacenPrincipal' => 'required|string|max:1',
            'almacenSegundo' => 'required|string|max:1',
            'idKarness' => 'required|integer|exists:karness,idKarness',
        ]);


        log::info('InsumosController - almacenPrincipal . ' . $request->almacenPrincipal .'' );


        log::info('InsumosController - Despues de validar');

        if ($validator->fails()) {
            log::info('InsumosController - ERROR DE VALIDACION . '. $validator->errors() .'' );
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $insumo = new Insumos();
        $insumo->Nombre = $request->input('Nombre');
        $insumo->descripcion = $request->input('descripcion');
        $insumo->control_cebado = $request->input('control_cebado');
        $insumo->control_emergencia = $request->input('control_emergencia');
        $insumo->almacenPrincipal = $request->input('almacenPrincipal');
        $insumo->almacenSegundo = $request->input('almacenSegundo');
        $insumo->idKarness = $request->input('idKarness');
        $insumo->save();

        return response()->json(['message' => 'Insumo creado exitosamente', 'insumo' => $insumo], 201);
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
        $validator = \Validator::make($request->all(), [
            'Nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'control_cebado' => 'required|string|max:1',
            'control_emergencia' => 'required|string|max:1',
            'almacenPrincipal' => 'required|string|max:1',
            'almacenSegundo' => 'required|string|max:1',
            'idKarness' => 'required|integer|exists:karness,idKarness',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $insumo = Insumos::findOrFail($id);
            $insumo->Nombre = $request->input('Nombre');
            $insumo->descripcion = $request->input('descripcion');
            $insumo->control_cebado = $request->input('control_cebado');
            $insumo->control_emergencia = $request->input('control_emergencia');
            $insumo->almacenPrincipal = $request->input('almacenPrincipal');
            $insumo->almacenSegundo = $request->input('almacenSegundo');
            $insumo->idKarness = $request->input('idKarness');
            $insumo->save();

            return response()->json(['message' => 'Insumo actualizado exitosamente', 'insumo' => $insumo], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Insumo no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno al actualizar el insumo'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $insumo = Insumos::findOrFail($id);
            $insumo->delete();
            return response()->json(['message' => 'Insumo eliminado exitosamente'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Insumo no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno al eliminar el insumo'], 500);
        }
    }
}
