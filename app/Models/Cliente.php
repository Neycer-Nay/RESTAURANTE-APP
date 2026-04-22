<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre_completo',
        'razon_social',
        'email',
        'telefono',
        'direccion',
        'tipo_documento',
        'numero_documento',
        'fecha_registro',
        'activo',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'activo' => 'boolean',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_cliente');
    }
}
