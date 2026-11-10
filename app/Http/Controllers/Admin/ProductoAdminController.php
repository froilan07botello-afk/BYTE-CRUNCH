<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductoAdminController extends Controller
{
    /**
     * Muestra el listado de productos en el panel administrativo.
     */
    public function index(): View
    {
        $productos = Producto::orderBy('id', 'desc')->get();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function crear(): View
    {
        return view('admin.productos.crear');
    }

    /**
     * Guarda el nuevo producto en la base de datos.
     */
    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|string|max:255',
        ]);

        Producto::create([
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
            'precio' => $datos['precio'],
            'imagen' => $datos['imagen'] ?? null,
            'disponible' => true, // Por defecto se crea disponible
        ]);

        return redirect()->route('admin.productos.listar')
            ->with('success', '¡El churro se creó exitosamente!');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function editar(Producto $producto): View
    {
        return view('admin.productos.editar', compact('producto'));
    }

    /**
     * Actualiza los datos del producto en la base de datos.
     */
    public function actualizar(Request $request, Producto $producto): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|string|max:255',
        ]);

        $producto->update([
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
            'precio' => $datos['precio'],
            'imagen' => $datos['imagen'] ?? $producto->imagen,
        ]);

        return redirect()->route('admin.productos.listar')
            ->with('success', 'El churro se actualizó correctamente.');
    }

    /**
     * Cambia la disponibilidad (activo/inactivo) del producto.
     */
    public function cambiarDisponibilidad(Producto $producto): RedirectResponse
    {
        $producto->update([
            'disponible' => !$producto->disponible,
        ]);

        $estadoTexto = $producto->disponible ? 'disponible' : 'no disponible';

        return redirect()->route('admin.productos.listar')
            ->with('success', "El estado del churro cambió a: {$estadoTexto}.");
    }
}
