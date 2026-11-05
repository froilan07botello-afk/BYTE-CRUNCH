<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class PedidoController extends Controller
{
    public function store(Request $request)
    {
    /*
    Validamos los datos que recibimos del formulario.
    */
        $datos = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'referencia' => 'nullable|string|max:255',

            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|integer|distinct|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1|max:50',
        ]);

        /*
        Obtenemos los ID y consultamos los productos disponibles.
        */
        $idsProductos = collect($datos['productos'])
            ->pluck('id')
            ->all();

        $productos = Producto::whereIn('id', $idsProductos)
            ->where('disponible', true)
            ->get()
            ->keyBy('id');

        if ($productos->count() !== count($idsProductos)) {
            return back()
                ->withErrors([
                    'productos' => 'Uno o más productos ya no están disponibles.'
                ])
                ->withInput();
        }

        /*
        Calculamos el total usando los precios de MySQL.
        */
        $total = 0;

        foreach ($datos['productos'] as $item) {
            $producto = $productos->get($item['id']);

            $subtotal = round(
                (float) $producto->precio * $item['cantidad'],
                2
            );

            $total += $subtotal;
        }

        $total = round($total, 2);

        $pedido= DB::transaction(function () use ($datos, $productos ,$total)
        {
             // Guardamos los datos generales del pedido.
            $pedido = Pedido::create([
                'nombre_cliente' => $datos['nombre_cliente'],
                'telefono' => $datos['telefono'],
                'direccion' => $datos['direccion'],
                'referencia' => $datos['referencia'] ?? null,
                'total' => $total,
                'estado' => 'Pendiente',
            ]);

        // Guardamos cada producto que forma parte del pedido.
        foreach ($datos['productos'] as $item)
        {

            $producto = $productos->get($item['id']);

            $subtotal = round(
                (float) $producto->precio * $item['cantidad'],
                2
            );

            $pedido->detalles()->create([
                'producto_id' => $producto->id,
                'nombre_producto' => $producto->nombre,
                'precio_unitario' => $producto->precio,
                'cantidad' => $item['cantidad'],
                'subtotal' => $subtotal,
            ]);
        }

        return $pedido;
         });
        return redirect('/seguimiento')
        ->with('success', '¡Tu pedido se registró correctamente!');
    }

    public function index(): View
    {
        $pedidos = Pedido::with('detalles')
            ->latest()
            ->get();

        $totalPendientes = $pedidos->where('estado', 'Pendiente')->count();

        $totalPreparacion = $pedidos->where('estado', 'En preparación')->count();

        $totalEntregados = $pedidos->where('estado', 'Entregado')->count();

        return view('churros.seguimiento', compact(
            'pedidos',
            'totalPendientes',
            'totalPreparacion',
            'totalEntregados'
        ));
    }

        /*
           1. Recibe el pedido a modificar
            2.comprueba que el estado sea alguno de los 3 que tenemos
            3.actualiza el campo estado desde la BD
            4.Regresa a la pagina seguimiento con un mensaje de confirmacion
        */
    public function actualizarEstado(Request $request, Pedido $pedido)
    {
        $datos = $request->validate([
            'estado' => 'required|in:Pendiente,En preparación,Entregado',
        ]);

        $pedido->update([
            'estado' => $datos['estado'],
        ]);

        return redirect()->route('pedidos.index')
            ->with('success', 'El estado del pedido se actualizó correctamente.');
    }



}
