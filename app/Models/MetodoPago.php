<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pagos';

    protected $fillable = [
        'nombre_metodo',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_metodo_pago');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_metodo_pago');
    }
}
