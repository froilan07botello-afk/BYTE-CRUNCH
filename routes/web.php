<?php

use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\ProductoAdminController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Ruta principal: muestra el login si no hay sesión, o redirige según el rol si ya está autenticado
Route::get('/', function () {
    if (Auth::check()) {
        return (Auth::user()->rol ?? 'cliente') === 'admin'
            ? redirect()->route('admin.pedidos.index')
            : redirect()->route('catalogo.index');
    }

    return view('auth.login');
})->name('inicio');

// Rutas exclusivas para usuarios con rol 'cliente'
Route::middleware(['auth', 'rol:cliente'])->group(function () {
    Route::get('/catalogo', [ProductoController::class, 'index'])
        ->name('catalogo.index');

    Route::get('/seguimiento', [PedidoController::class, 'index'])
        ->name('pedidos.index');

    Route::post('/pedidos', [PedidoController::class, 'store'])
        ->name('pedidos.store');

    Route::patch('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])
        ->name('pedidos.actualizarEstado');
});

// Rutas exclusivas para usuarios con rol 'admin'
Route::middleware(['auth', 'rol:admin'])->prefix('admin')->group(function () {
    // Pedidos
    Route::get('/pedidos', [PedidoAdminController::class, 'index'])
        ->name('admin.pedidos.index');

    Route::patch('/pedidos/{pedido}/estado', [PedidoAdminController::class, 'actualizarEstado'])
        ->name('admin.pedidos.actualizarEstado');

    // Productos (nombres en español)
    Route::get('/productos', [ProductoAdminController::class, 'index'])
        ->name('admin.productos.listar');

    Route::get('/productos/nuevo', [ProductoAdminController::class, 'crear'])
        ->name('admin.productos.nuevo');

    Route::post('/productos', [ProductoAdminController::class, 'guardar'])
        ->name('admin.productos.guardar');

    Route::get('/productos/{producto}/editar', [ProductoAdminController::class, 'editar'])
        ->name('admin.productos.editar');

    Route::patch('/productos/{producto}', [ProductoAdminController::class, 'actualizar'])
        ->name('admin.productos.actualizar');

    Route::patch('/productos/{producto}/disponibilidad', [ProductoAdminController::class, 'cambiarDisponibilidad'])
        ->name('admin.productos.disponibilidad');
});

// Perfil de usuario autenticado (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
    return (Auth::user()->rol ?? 'cliente') === 'admin'
        ? redirect()->route('admin.pedidos.index')
        : redirect()->route('catalogo.index');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
