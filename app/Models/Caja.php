<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';

    protected $fillable = [
        'id_usuario',
        'fecha_apertura',
        'fecha_cierre',
        'monto_apertura',
        'monto_cierre',
        'estado_caja',
    ];

    protected $casts = [
        'id_usuario' => 'integer',
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
        'monto_apertura' => 'decimal:2',
        'monto_cierre' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_caja');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_caja');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoCaja::class, 'id_caja');
    }
}
