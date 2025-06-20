<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacen';
    protected $primaryKey = 'idAlmacen'; 
    protected $fillable = [
        'zona',
        'idInsumo',
        'cant_stock',
        'lote',
        'fecha_guardado',
        'fechaVencimiento',
        'updated_at',
        'created_at',
    ];
    
    public function Insumos()
    {
        return $this->belongsTo(Insumos::class, 'idInsumo');
    }

    

}
