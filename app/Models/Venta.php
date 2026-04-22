<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'id_cliente',
        'id_usuario',
        'fecha_venta',
        'total_venta',
    ];

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
