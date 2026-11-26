<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class PedidoController extends Controller
{
    public function store(Request $request)
    {
       /*
         * Limpiamos espacios sobrantes y normalizamos el teléfono (quitando
         * espacios, guiones, paréntesis o signos) antes de validar.
         */
        $telefonoLimpio = preg_replace('/\D+/', '', (string) $request->input('telefono', ''));

        $request->merge([
            'nombre_cliente' => trim((string) $request->input('nombre_cliente', '')),
            'telefono' => $telefonoLimpio,
            'direccion' => trim((string) $request->input('direccion', '')),
            'referencia' => $request->filled('referencia')
                ? trim((string) $request->input('referencia'))
                : null,
            'metodo_pago' => $request->input('metodo_pago', 'efectivo'),
            'referencia_pago' => $request->filled('referencia_pago')
                ? trim((string) $request->input('referencia_pago'))
                : null,
        ]);

        $datos = $request->validate([
            'nombre_cliente' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'regex:/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]+$/u',
            ],
            'telefono' => [
                'required',
                'string',
                'digits:10',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $secuenciasBloqueadas = [
                        '0123456789',
                        '1234567890',
                        '9876543210',
                        '0987654321',
                    ];

                    if (preg_match('/^(\d)\1{9}$/', (string) $value) || in_array((string) $value, $secuenciasBloqueadas, true)) {
                        $fail('Ingresa un número de teléfono válido de 10 dígitos.');
                    }
                },
            ],
            'direccion' => [
                'required',
                'string',
                'min:15',
                'max:255',
                'regex:/\d/',
            ],
            'referencia' => [
                'nullable',
                'string',
                'max:200',
            ],
            'metodo_pago' => [
                'required',
                'string',
                'in:efectivo,transferencia',
            ],
            'referencia_pago' => [
                'nullable',
                'string',
                'max:100',
            ],

            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|integer|distinct|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1|max:50',
        ], [
            'nombre_cliente.required' => 'El nombre completo es obligatorio.',
            'nombre_cliente.min' => 'El nombre completo debe tener al menos 3 caracteres.',
            'nombre_cliente.max' => 'El nombre completo no puede superar los 60 caracteres.',
            'nombre_cliente.regex' => 'El nombre solo puede contener letras, acentos, ñ y espacios.',

            'telefono.required' => 'El teléfono de contacto es obligatorio.',
            'telefono.digits' => 'El teléfono debe contener exactamente 10 dígitos.',

            'direccion.required' => 'La dirección de entrega es obligatoria.',
            'direccion.min' => 'Escribe al menos 15 caracteres para indicar calle, colonia y referencias.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
            'direccion.regex' => 'Incluye al menos un número (casa, lote o manzana) en la dirección.',

            'referencia.max' => 'Las referencias no pueden superar los 200 caracteres.',

            'metodo_pago.required' => 'Selecciona un método de pago.',
            'metodo_pago.in' => 'El método de pago seleccionado no es válido.',
            'referencia_pago.max' => 'La referencia de pago no puede superar los 100 caracteres.',

            'productos.required' => 'Agrega al menos un churro a tu pedido.',
            'productos.min' => 'Agrega al menos un churro a tu pedido.',
        ]);

        /*
         * Obtenemos los ID y consultamos los productos disponibles.
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
         * Calculamos el total usando los precios de MySQL.
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

        $codigoEntrega = (string) random_int(1000, 9999);

        $pedido = DB::transaction(function () use ($request, $datos, $productos, $total, $codigoEntrega) {
            // Guardamos los datos generales del pedido.
            $pedido = Pedido::create([
                'user_id' => $request->user()?->id,
                'nombre_cliente' => $datos['nombre_cliente'],
                'telefono' => $datos['telefono'],
                'direccion' => $datos['direccion'],
                'referencia' => $datos['referencia'],
                'total' => $total,
                'estado' => 'Pendiente',
                'metodo_pago' => $datos['metodo_pago'],
                'referencia_pago' => $datos['referencia_pago'],
                'codigo_entrega' => $codigoEntrega,
            ]);

            // Guardamos cada producto que forma parte del pedido.
            foreach ($datos['productos'] as $item) {
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

        return redirect()->route('pedidos.index')
            ->with('success', '¡Tu pedido se registró correctamente!');
    }

    public function index(): View
    {
        $pedidos = Pedido::with('detalles')
            ->where('user_id', auth()->id())
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
            'estado' => ['required', 'in:Pendiente,En preparación,Entregado'],
            'nota_entrega' => ['nullable', 'string', 'max:255'],
        ]);

        $esEntregado = $datos['estado'] === 'Entregado';

        $pedido->update([
            'estado' => $datos['estado'],
            'entregado_en' => $esEntregado ? ($pedido->entregado_en ?? now()) : null,
            'nota_entrega' => $esEntregado ? (trim((string) ($datos['nota_entrega'] ?? '')) ?: $pedido->nota_entrega) : null,
        ]);
        return back()->with('success', 'El estado del pedido #' . $pedido->id . ' se actualizó correctamente.');
    }



}
