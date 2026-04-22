<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'id_caja',
        'id_cliente',
        'id_usuario',
        'fecha_venta',
        'subtotal',
        'total',
        'estado',
    ];

    protected $casts = [
        'id_caja' => 'integer',
        'id_cliente' => 'integer',
        'id_usuario' => 'integer',
        'fecha_venta' => 'datetime',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'estado' => 'boolean',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }

    public function pagosVenta()
    {
        return $this->hasMany(PagoVenta::class, 'id_venta');
    }
}
