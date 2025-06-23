<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petitorio extends Model
{
    use HasFactory;
    protected $primaryKey = 'idpetitorio';
    protected $table = 'petitorio';
    protected $fillable = [
        'fecha_servicio',
        'fecha_creado',
        'insumos_cant',
        'cant_movida',
        'status_proceso',
        'status_confirmacion'
    ];

}
