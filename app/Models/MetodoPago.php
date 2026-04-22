<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pagos';

    protected $fillable = [
        'nombre_metodo',
    ];

    public function pagosVenta()
    {
        return $this->hasMany(PagoVenta::class, 'id_metodo_pago');
    }

    public function pagosCompra()
    {
        return $this->hasMany(PagoCompra::class, 'id_metodo_pago');
    }

    public function ventas()
    {
        return $this->pagosVenta();
    }

    public function compras()
    {
        return $this->pagosCompra();
    }
}
