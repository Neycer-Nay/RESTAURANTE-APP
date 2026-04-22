<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalUsuarios' => User::count(),
            'usuariosActivos' => User::where('activo', true)->count(),
            'totalRoles' => Rol::count(),
        ]);
    }
}
