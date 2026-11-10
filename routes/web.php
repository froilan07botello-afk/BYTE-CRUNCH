<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\ProductoAdminController;

Route::get('/', [ProductoController::class, 'index']);

Route::get('/seguimiento', [PedidoController::class, 'index'])
    ->name('pedidos.index');

Route::post('/pedidos', [PedidoController::class, 'store'])
    ->name('pedidos.store');

Route::patch('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])
    ->name('pedidos.actualizarEstado');

// Rutas del Panel Administrativo
Route::get('/admin/pedidos', [PedidoAdminController::class, 'index'])
    ->name('admin.pedidos.index');

Route::patch('/admin/pedidos/{pedido}/estado', [PedidoAdminController::class, 'actualizarEstado'])
    ->name('admin.pedidos.actualizarEstado');
// Rutas de Administración de Productos
Route::get('/admin/productos', [ProductoAdminController::class, 'index'])
    ->name('admin.productos.listar');

Route::get('/admin/productos/nuevo', [ProductoAdminController::class, 'crear'])
    ->name('admin.productos.nuevo');

Route::post('/admin/productos', [ProductoAdminController::class, 'guardar'])
    ->name('admin.productos.guardar');

Route::get('/admin/productos/{producto}/editar', [ProductoAdminController::class, 'editar'])
    ->name('admin.productos.editar');

Route::patch('/admin/productos/{producto}', [ProductoAdminController::class, 'actualizar'])
    ->name('admin.productos.actualizar');

Route::patch('/admin/productos/{producto}/disponibilidad', [ProductoAdminController::class, 'cambiarDisponibilidad'])
    ->name('admin.productos.disponibilidad');
