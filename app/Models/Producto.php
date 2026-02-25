<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = ['nombre', 'cantidad', 'estatus'];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
