<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAjuste extends Model
{
    protected $table = 'tipos_ajuste';

    protected $fillable = [
        'nombre_ajuste',
        'descripcion',
    ];

    public function ajustes()
    {
        return $this->hasMany(Ajuste::class, 'id_tipo_ajuste');
    }
}
