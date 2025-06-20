<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Insumos;
use App\Models\Karness;

use App\Models\MovimientoAlmacen;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Asegúrate de importar Carbon
use Illuminate\Support\Facades\Validator;


class AlmacenController extends Controller
{

   


    public function index()
    {
        $karness = Karness::with('insumos')->orderBy('idkarness')->get();
        $ListInsumos = Insumos::all();



        return view('almacen.index', compact('karness','ListInsumos'));
    }



    public function karness($almacen,$insumoId)
    {
        try{

            $insumoActual = Insumos::find($insumoId);
        if (!$insumoActual) {
            Log::warning("Insumo con ID {$this->insumoId} no encontrado en cargarInsumos.");
            return;
        }


        $this->karness = $insumoActual->idKarness; 

        $query = Insumos::where('idKarness', $this->karness);

        if ($almacen === 'Principal') {
            $query->where('almacenPrincipal', 'Y');
        } elseif ($almacen === 'Secundario') {
            $query->where('almacenSegundo', 'Y');
        }

        $listaInsumos = $query->orderBy('idInsumo')->get();

           return view('almacen.karness', compact('almacen','insumoId','listaInsumos'));

        }catch(e){
            throw new Exception("Error Processing Request", 1);
        }

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
