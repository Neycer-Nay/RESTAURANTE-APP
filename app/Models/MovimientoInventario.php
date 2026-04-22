<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimiento_inventarios';

    protected $fillable = [
        'id_producto',
        'tipo_movimiento',
        'cantidad',
        'referencia_id',
        'fecha_movimiento',
        'concepto',
    ];

    protected $casts = [
        'id_producto' => 'integer',
        'cantidad' => 'integer',
        'referencia_id' => 'integer',
        'fecha_movimiento' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
