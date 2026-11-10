<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Admin\PedidoAdminController;

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
