<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductoController::class, 'index']);

Route::get('/seguimiento', function () {
    return view('churros.seguimiento');
});


