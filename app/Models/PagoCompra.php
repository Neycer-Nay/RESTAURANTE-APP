<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCompra extends Model
{
    protected $table = 'pago_compras';

    protected $fillable = [
        'id_compra',
        'id_metodo_pago',
        'monto',
        'referencia',
    ];

    protected $casts = [
        'id_compra' => 'integer',
        'id_metodo_pago' => 'integer',
        'monto' => 'decimal:2',
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
