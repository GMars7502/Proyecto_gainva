<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumos extends Model
{
    use HasFactory;
    protected $table = 'insumos';
    protected $primaryKey = 'idInsumo'; 
    protected $fillable = [
        'idKarness',
        'Nombre',
        'descripcion',
        'control_cebado',
        'control_emergencia',
        'almacenPrincipal',
        'almacenSegundo'
    ];

    public function Karness()
    {
        return $this->belongsTo(Karness::class, 'idKarness');
    }


}
