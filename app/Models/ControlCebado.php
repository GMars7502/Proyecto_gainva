<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCebado extends Model
{
    use HasFactory;
    protected $table = 'control_cebado';
    protected $fillable = [
        'fk_insumos',
        'actualFecha',
        'siguienteFecha',
        'lote1',
        'cant1',
        'lote2',
        'cant2',
        'lote3',
        'cant3',
        'lote4',
        'cant4',
        'status',
        'updated_at',
        'created_at'
    ];
    public function Insumos()
    {
        return $this->belongsTo(Insumos::class, 'fk_insumos');
    }

}
