<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('churros.catalago');
});

Route::get('/seguimiento', function () {
    return view('churros.seguimiento');
});


