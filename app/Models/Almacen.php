<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacen';
    protected $fillable = [
        'Fk_MA',
        'zona',
        'cant_stock',
        'lote',
        'fechaVencimiento',
    ];
    
    
    public function MovimientoAlmacen()
    {
        return $this->belongsTo(MovimientoAlmacen::class, 'Fk_MA');
    }

    

}
