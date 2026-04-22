<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tiposAjusteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('tipo_ajustes')->upsert([
            [
                'nombre_tipo' => 'inicial',
                'descripcion' => 'Carga inicial de inventario',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_tipo' => 'positivo',
                'descripcion' => 'Ajuste de incremento de inventario',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_tipo' => 'negativo',
                'descripcion' => 'Ajuste de disminucion de inventario',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['nombre_tipo'], ['descripcion', 'updated_at']);
    }
}
