<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;

Route::get('/', [ProductoController::class, 'index']);

Route::get('/seguimiento', [PedidoController::class, 'index'])
    ->name('pedidos.index');

Route::post('/pedidos', [PedidoController::class, 'store'])
    ->name('pedidos.store');

Route::patch('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])
    ->name('pedidos.actualizarEstado');

