<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Producto;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::where('disponible', true)
            ->orderBy('id')
            ->get();

        return view('churros.catalogo', compact('productos'));
    }
}
