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
     * Actualiza el estado de un pedido desde el panel y nos registra evidencia al entregar
     */
    public function actualizarEstado(Request $request, Pedido $pedido): RedirectResponse
    {
       $datos = $request->validate([
            'estado' => 'required|in:Pendiente,En preparación,Entregado',
            'nota_entrega' => 'nullable|string|max:255',
        ], [
            'estado.required' => 'Selecciona un estado válido.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'nota_entrega.max' => 'La nota de entrega no puede superar los 255 caracteres.',
        ]);

        $notaLimpia = isset($datos['nota_entrega']) && trim($datos['nota_entrega']) !== ''
            ? trim($datos['nota_entrega'])
            : null;

        $actualizacion = [
            'estado' => $datos['estado'],
        ];

        if ($datos['estado'] === 'Entregado') {
            $actualizacion['entregado_en'] = $pedido->entregado_en ?? now();
            $actualizacion['nota_entrega'] = $notaLimpia ?? $pedido->nota_entrega;
        } else {
            $actualizacion['entregado_en'] = null;
            $actualizacion['nota_entrega'] = null;
        }

        $pedido->update($actualizacion);

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'El estado del pedido se actualizó correctamente.');
    }
}
