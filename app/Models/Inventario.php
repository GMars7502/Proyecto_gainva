<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'inventario';
    protected $fillable = [
        'idInsumo',
        'cant_atencion',
        'tipo_cantidad'
    ];

    public function Insumos()
    {
        return $this->belongsTo(Insumos::class, 'idInsumo');
    }


}
