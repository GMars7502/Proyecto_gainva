<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Karness;

class KarnessList extends Component
{
    public $inventario = '';
    public $karness;
    protected $listeners = ['inventarioCambiado' => 'updatedInventario'];

    public function mount()
    {
        if (!$this->inventario) {
            $this->inventario = 'Principal'; // O el valor por defecto deseado
        }
        $this->loadKarness();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'inventario') {
            $this->loadKarness();
        }
    }

    public function updatedInventario($valor)
    {    // \Log::info('Inventario seleccionado desde Updated: ' . $this->inventario);
            
        if ($valor === 'inventario') {
            $this->loadKarness();
        }
    }

    public function loadKarness()
    {
        
        if ($this->inventario == 'Total') {
            $this->karness = Karness::with('insumos')->orderBy('idKarness')->get();
        } 
        elseif ($this->inventario == 'Principal') {
            $this->karness = Karness::whereHas('insumos', function ($query) {
                $query->where('almacenPrincipal', 'Y');
            })->with(['insumos' => function ($query) {
                $query->where('almacenPrincipal', 'Y');
            }])->orderBy('idKarness')->get(); 
            
        } 
        elseif ($this->inventario == 'Secundario') {
            $this->karness = Karness::whereHas('insumos', function ($query) {
                $query->where('almacenSegundo', 'Y');
            })->with(['insumos' => function ($query) {
                $query->where('almacenSegundo', 'Y');
            }])->orderBy('idKarness')->get();
        } 
        else {
            $this->karness = Karness::with('insumos')->orderBy('idKarness')->get();
        }

        //dd($this->karness);
        //$this->emit('refreshKarness');
        //\Log::info('Inventario seleccionado desde loadKarness: ' . $this->inventario);
    }

    public function render()
    {
        $inventario = $this->inventario;
        return view('livewire.components.karness-list');
    }

    public function hydrate()
    {
        $this->loadKarness();
    }
}
