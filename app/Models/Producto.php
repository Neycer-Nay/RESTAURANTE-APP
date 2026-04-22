<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    
    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio',
        'id_marca',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_producto');
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'id_producto');
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'id_producto');
    }
}
