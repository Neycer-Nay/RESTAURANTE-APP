<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodos_pago';

    protected $fillable = [
        'nombre_metodo',
        'descripcion',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_metodo_pago');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_metodo_pago');
    }
}
