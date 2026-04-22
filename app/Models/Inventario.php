<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'id_producto',
        'cantidad_actual',
        'cantidad_minima',
        'cantidad_maxima',
        'ultima_actualizacion',
    ];

    protected $casts = [
        'id_producto' => 'integer',
        'cantidad_actual' => 'integer',
        'cantidad_minima' => 'integer',
        'cantidad_maxima' => 'integer',
        'ultima_actualizacion' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    
}
