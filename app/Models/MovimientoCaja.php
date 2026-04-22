<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimiento_cajas';

    protected $fillable = [
        'id_caja',
        'tipo_movimiento',
        'monto',
        'fecha_movimiento',
        'concepto',
        'detalle',
    ];

    protected $casts = [
        'id_caja' => 'integer',
        'monto' => 'decimal:2',
        'fecha_movimiento' => 'datetime',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }
}
