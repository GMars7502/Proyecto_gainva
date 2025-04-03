<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Insumos;
use App\Models\Karness;

class AlmacenController extends Controller
{

   


    public function index()
    {
        $karness = Karness::with('insumos')->orderBy('idkarness')->get();
        $insumos = Insumos::all();



        return view('almacen.index', compact('karness'));
    }

    public function karness($id,$almacen)
    {

        return view('almacen.karness', compact('id','almacen'));

    }


    
}
