<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'id_caja',
        'id_usuario',
        'id_proveedor',
        'fecha_compra',
        'subtotal',
        'total',
        'estado',
    ];

    protected $casts = [
        'id_caja' => 'integer',
        'id_usuario' => 'integer',
        'id_proveedor' => 'integer',
        'fecha_compra' => 'datetime',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'estado' => 'boolean',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra');
    }

    public function pagosCompra()
    {
        return $this->hasMany(PagoCompra::class, 'id_compra');
    }
}
