<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAjuste extends Model
{
    protected $table = 'tipo_ajustes';

    protected $fillable = [
        'nombre_tipo',
        'descripcion',
    ];

    public function ajustes()
    {
        return $this->hasMany(AjusteInventario::class, 'tipo_ajuste');
    }
}
