<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    protected $table = 'ajuste_inventarios';

    protected $fillable = [
        'id_usuario',
        'tipo_ajuste',
        'fecha_ajuste',
        'concepto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function tipoAjuste()
    {
        return $this->belongsTo(TipoAjuste::class, 'tipo_ajuste');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleAjuste::class, 'id_ajuste');
    }
}
