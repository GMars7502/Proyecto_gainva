<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karness extends Model
{
    use HasFactory;
    protected $table = 'karness';
    protected $primaryKey = 'idKarness'; 
    protected $fillable = [
        'nombre'
    ];

    public function Insumos()
    {
        return $this->hasMany(Insumos::class, 'idKarness');
    }


}
