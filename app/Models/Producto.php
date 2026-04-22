<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    
    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio_venta',
        'margen_ganancia',
        'precio_compra',
        'tipo_producto',
        'id_categoria',
        'id_marca',
        'fecha_creacion',
        'activo',
    ];

    protected $casts = [
        'precio_venta'    => 'decimal:2',
        'margen_ganancia' => 'decimal:2',
        'precio_compra'   => 'decimal:2',
        'activo'          => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

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
