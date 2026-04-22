<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleAjuste extends Model
{
    protected $table = 'detalle_ajustes';

    protected $fillable = [
        'id_ajuste',
        'id_producto',
        'cantidad',
    ];

    protected $casts = [
        'id_ajuste' => 'integer',
        'id_producto' => 'integer',
        'cantidad' => 'integer',
    ];

    public function ajusteInventario()
    {
        return $this->belongsTo(AjusteInventario::class, 'id_ajuste');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
