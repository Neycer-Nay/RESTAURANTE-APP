<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class metodosPagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('metodo_pagos')->upsert([
            [
                'nombre_metodo' => 'efectivo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_metodo' => 'transferencia bancaria',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_metodo' => 'tarjeta',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['nombre_metodo'], ['updated_at']);
    }
}
