<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Rol::query()->firstOrCreate(
            ['nombre_rol' => 'superadministrador'],
            ['descripcion' => 'Acceso total al sistema']
        );
        $email = env('ADMIN_EMAIL', 'admin@jiba.local');
        $admin = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrador'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin123*')),
                'id_rol' => $adminRole->id,
                'activo' => true,
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->wasRecentlyCreated) {
            $admin->forceFill(
                [
                    'id_rol' => $adminRole->id,
                    'activo' => true,
                ]
            )->save();
        }
    }
}
