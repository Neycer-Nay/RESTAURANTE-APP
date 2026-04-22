<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class rolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('rols')->upsert([
            [
                'nombre_rol' => 'superadministrador',
                'descripcion' => 'Acceso total al sistema',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_rol' => 'supervisor',
                'descripcion' => 'Supervisa operaciones',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_rol' => 'cajero',
                'descripcion' => 'Gestiona cobros y caja',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['nombre_rol'], ['descripcion', 'updated_at']);
    }
}
