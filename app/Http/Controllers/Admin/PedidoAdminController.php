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
     Nos mostrara los pedidos que se han hecho y los mostrara en el panel administrativo con filtro por estado y busqueda
     */
    public function index(Request $request): View
    {
       // 1. Leemos los filtros que vienen en la URL (?estado=...&buscar=...)
        $estadoFiltro = $request->query('estado', 'Todos');
        $busqueda = trim((string) $request->query('buscar', ''));

        // Validamos que el estado sea uno de los permitidos
        $estadosPermitidos = ['Todos', 'Pendiente', 'En preparación', 'Entregado'];
        if (!in_array($estadoFiltro, $estadosPermitidos, true)) {
            $estadoFiltro = 'Todos';
        }

        // 2. Calculamos los contadores globales para las tarjetas superiores
        $totalPendientes = Pedido::where('estado', 'Pendiente')->count();
        $totalPreparacion = Pedido::where('estado', 'En preparación')->count();
        $totalEntregados = Pedido::where('estado', 'Entregado')->count();
        $inicioDia = now('America/Mexico_City')->startOfDay()->utc();
        $finDia = now('America/Mexico_City')->endOfDay()->utc();

        $ventasHoy = (float) Pedido::whereBetween('created_at', [$inicioDia, $finDia])
            ->sum('total');
        // 3. Armamos la consulta de pedidos aplicando los filtros elegidos
        $consulta = Pedido::with('detalles')->latest();

        if ($estadoFiltro !== 'Todos') {
            $consulta->where('estado', $estadoFiltro);
        }

        if ($busqueda !== '') {
            // Si el admin escribe "#15" o "15", buscamos también por ID exacto
            $folioNumerico = ltrim($busqueda, '#');

            $consulta->where(function ($q) use ($busqueda, $folioNumerico) {
                if (ctype_digit($folioNumerico)) {
                    $q->orWhere('id', (int) $folioNumerico);
                }

                $q->orWhere('nombre_cliente', 'like', "%{$busqueda}%")
                  ->orWhere('telefono', 'like', "%{$busqueda}%")
                  ->orWhere('codigo_entrega', 'like', "%{$busqueda}%");
            });
        }

        $pedidos = $consulta->get();

        return view('admin.pedidos.index', compact(
            'pedidos',
            'totalPendientes',
            'totalPreparacion',
            'totalEntregados',
            'ventasHoy',
            'estadoFiltro',
            'busqueda'
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
