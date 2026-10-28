<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\View\View;
class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::where('disponible', true)
            ->orderBy('id')
            ->get();

        return view('churros.catalago', compact('productos'));
    }
}
