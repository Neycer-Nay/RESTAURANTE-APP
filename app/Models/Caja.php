<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';

    protected $fillable = [
        'nombre_caja',
        'saldo_inicial',
        'saldo_final',
        'fecha_apertura',
        'fecha_cierre',
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_caja');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_caja');
    }
}
