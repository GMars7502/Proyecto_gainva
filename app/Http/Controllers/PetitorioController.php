<?php

namespace App\Http\Controllers;

use App\Models\Petitorio;
use Illuminate\Http\Request;

class PetitorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {



        return view('petitorio.index');
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
    public function show(Petitorio $petitorio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petitorio $petitorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petitorio $petitorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petitorio $petitorio)
    {
        //
    }
}
