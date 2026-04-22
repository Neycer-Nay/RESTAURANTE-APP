<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimiento_inventarios';

    protected $fillable = [
        'id_producto',
        'cantidad',
        'tipo_movimiento', // 'entrada' o 'salida'
        'fecha_movimiento',
        'concepto',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
