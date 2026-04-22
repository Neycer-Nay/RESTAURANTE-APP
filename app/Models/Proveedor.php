<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedors';

    protected $fillable = [
        'razon_social',
        'nombre_contacto',
        'telefono',
        'email',
        'direccion',
        'tipo_documento',
        'numero_documento',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_proveedor');
    }
}
