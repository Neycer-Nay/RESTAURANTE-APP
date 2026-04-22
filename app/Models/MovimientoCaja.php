<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimiento_cajas';

    protected $fillable = [
        'id_caja',
        'id_usuario',
        'tipo_movimiento',
        'monto',
        'fecha_movimiento',
        'concepto',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento');
    }
}
