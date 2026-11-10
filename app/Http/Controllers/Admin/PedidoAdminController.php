<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PedidoAdminController extends Controller
{
    /*
     Nos mostrara los pedidos que se han hecho y los mostrara en el panel administrativo
     */
    public function index(): View
    {
        $pedidos = Pedido::with('detalles')->latest()->get();

        $totalPendientes = $pedidos->where('estado', 'Pendiente')->count();
        $totalPreparacion = $pedidos->where('estado', 'En preparación')->count();
        $totalEntregados = $pedidos->where('estado', 'Entregado')->count();

        return view('admin.pedidos.index', compact(
            'pedidos',
            'totalPendientes',
            'totalPreparacion',
            'totalEntregados'
        ));
    }

    /**
     * Actualiza el estado de un pedido desde el panel.
     */
    public function actualizarEstado(Request $request, Pedido $pedido): RedirectResponse
    {
        $datos = $request->validate([
            'estado' => 'required|in:Pendiente,En preparación,Entregado',
        ]);

        $pedido->update([
            'estado' => $datos['estado'],
        ]);

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'El estado del pedido se actualizó correctamente.');
    }
}
