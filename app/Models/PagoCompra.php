<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCompra extends Model
{
    protected $table = 'pagos_compras';

    protected $fillable = [
        'id_compra',
        'id_metodo_pago',
        'monto_pagado',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }
}
