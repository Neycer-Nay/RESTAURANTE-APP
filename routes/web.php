<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware('guest.session')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth.session')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('roles', RolController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');

    Route::resource('categorias', CategoriaController::class)->except('show');
    Route::resource('marcas', MarcaController::class)->except('show');
    Route::resource('clientes', ClienteController::class)->except('show');
    Route::resource('proveedores', ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor'])
        ->except('show');
    Route::resource('metodos-pago', MetodoPagoController::class)
        ->parameters(['metodos-pago' => 'metodoPago'])
        ->except('show');
    Route::resource('productos', ProductoController::class)->except('show');
});
