<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoAlmacen extends Model
{
    use HasFactory;
    protected $table = 'movimiento_almacen';
    protected $fillable = [
        'fk_insumos',
        'fecha',
        'tipo_movimiento',
        'cant_movida',
        'stock',
        'factu_o_boleta',
        'observacion',
        'lote',
        'proveedor'
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'fk_insumos');
    }
}
