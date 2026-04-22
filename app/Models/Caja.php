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
}
