
@extends('layouts.app')

@section('titulo', 'Seguimiento de pedidos | BYTE & CRUNCH')

@section('content')

<header class="border-b border-orange-100 bg-white">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="/" class="text-xl font-black text-amber-950">
            BYTE <span class="text-orange-600">&</span> CRUNCH
        </a>

        <a href="/"
           class="rounded-xl bg-amber-950 px-4 py-3 text-sm font-bold text-white hover:bg-amber-900">
            Volver al catálogo
        </a>
    </nav>
</header>

<main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 sm:py-12">

    <section class="mb-8">


        <h1 class="mt-2 text-3xl font-black text-amber-950 sm:text-4xl">
            Seguimiento de pedidos
        </h1>

        <p class="mt-3 leading-6 text-stone-600">
            Consulta el estado de los pedidos de nuestra demostración.
        </p>
    </section>


<section class="mb-8">
    <h2 class="mb-4 text-lg font-black text-amber-950">
        Resumen de pedidos
    </h2>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
            <p class="text-sm font-semibold text-amber-900">Pendientes</p>
            <p id="total-pendientes" class="mt-2 text-3xl font-black text-amber-950">0</p>
        </article>

        <article class="rounded-2xl border border-orange-200 bg-orange-50 p-5">
            <p class="text-sm font-semibold text-orange-900">En preparación</p>
            <p id="total-preparacion" class="mt-2 text-3xl font-black text-orange-950">0</p>
        </article>

        <article class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <p class="text-sm font-semibold text-green-900">Entregados</p>
            <p id="total-entregados" class="mt-2 text-3xl font-black text-green-950">0</p>
        </article>
    </div>
</section>

<section id="lista-pedidos" class="space-y-5">
    <p id="sin-pedidos"
       class="rounded-xl border border-orange-200 bg-white p-6 text-center text-stone-600">
        Todavía no hay pedidos registrados en este navegador.
    </p>
</section>
</main>

@endsection


@push('scripts')
<script>
    const listaPedidos = document.getElementById('lista-pedidos');
    const avisoSinPedidos = document.getElementById('sin-pedidos');

    function leerPedidos() {
        try {
            const datos = JSON.parse(
                localStorage.getItem('byteCrunchPedidos') || '[]'
            );

            return Array.isArray(datos) ? datos : [];
        } catch {
            return [];
        }
    }

    function guardarPedidos(pedidos) {
        localStorage.setItem(
            'byteCrunchPedidos',
            JSON.stringify(pedidos)
        );
    }

    function crearTexto(etiqueta, texto, clases = '') {
        const elemento = document.createElement(etiqueta);
        elemento.textContent = texto;
        elemento.className = clases;
        return elemento;
    }

    function mostrarPedidos()
     {
        const pedidos = leerPedidos();

        document.getElementById('total-pendientes').textContent =
            pedidos.filter(pedido => pedido.estado === 'Pendiente').length;

        document.getElementById('total-preparacion').textContent =
            pedidos.filter(pedido => pedido.estado === 'En preparación').length;

        document.getElementById('total-entregados').textContent =
            pedidos.filter(pedido => pedido.estado === 'Entregado').length;

        listaPedidos.replaceChildren();
        avisoSinPedidos.classList.toggle('hidden', pedidos.length > 0);

        pedidos.forEach((pedido) => {
            const tarjeta = document.createElement('article');
            tarjeta.className =
                'rounded-2xl border border-orange-100 bg-white p-5 shadow-sm';

           const encabezadoPedido = document.createElement('div');
            encabezadoPedido.className =
                'flex flex-col gap-3 border-b border-orange-100 pb-4 sm:flex-row sm:items-center sm:justify-between';

            const informacionCliente = document.createElement('div');

            informacionCliente.appendChild(crearTexto(
                'p',
                `Pedido #${pedido.id}`,
                'text-sm font-semibold text-stone-500'
            ));

            informacionCliente.appendChild(crearTexto(
                'h2',
                pedido.nombre || 'Cliente sin nombre',
                'mt-1 text-xl font-black text-amber-950 sm:text-2xl'
            ));

            encabezadoPedido.appendChild(informacionCliente);
            tarjeta.appendChild(encabezadoPedido);

            tarjeta.appendChild(crearTexto(
                'p',
                `Teléfono: ${pedido.telefono}`,
                'mt-2 text-sm text-stone-600'
            ));

            tarjeta.appendChild(crearTexto(
                'p',
                `Dirección: ${pedido.direccion}`,
                'mt-1 text-sm text-stone-600'
            ));

            if (pedido.referencia) {
                tarjeta.appendChild(crearTexto(
                    'p',
                    `Referencia: ${pedido.referencia}`,
                    'mt-1 text-sm text-stone-600'
                ));
            }

            const productos = document.createElement('ul');
            productos.className = 'mt-4 space-y-1 text-sm text-stone-700';

            (Array.isArray(pedido.productos) ? pedido.productos : [])
                .forEach((producto) => {
                    productos.appendChild(crearTexto(
                        'li',
                        `${producto.nombre} × ${producto.cantidad} — ${
                            (producto.precio * producto.cantidad)
                                .toLocaleString('es-MX', {
                                    style: 'currency',
                                    currency: 'MXN'
                                })
                        }`
                    ));
                });

            tarjeta.appendChild(productos);

            tarjeta.appendChild(crearTexto(
                'p',
                `Total: ${Number(pedido.total).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                })}`,
                'mt-4 text-lg font-black text-orange-600'
            ));

            tarjeta.appendChild(crearTexto(
                'p',
                `Fecha: ${pedido.fecha}`,
                'mt-1 text-xs text-stone-500'
            ));

            const etiquetaEstado = crearTexto(
                'span',
                pedido.estado,
                'rounded-full px-3 py-2 text-sm font-bold'
            );

            const actualizarColor = () => {
                etiquetaEstado.className =
                    'rounded-full px-3 py-2 text-sm font-bold';

                if (pedido.estado === 'Pendiente') {
                    etiquetaEstado.classList.add(
                        'bg-amber-100', 'text-amber-900'
                    );
                } else if (pedido.estado === 'En preparación') {
                    etiquetaEstado.classList.add(
                        'bg-orange-100', 'text-orange-900'
                    );
                } else {
                    etiquetaEstado.classList.add(
                        'bg-green-100', 'text-green-900'
                    );
                }
            };

            actualizarColor();

            const filaEstado = document.createElement('div');
            filaEstado.className =
                'mt-5 flex flex-col items-start gap-3 rounded-xl bg-orange-50 p-4 sm:flex-row sm:items-center sm:justify-between';

            filaEstado.appendChild(crearTexto(
                'span',
                'Estado del pedido:',
                'font-bold text-amber-950'
            ));

            filaEstado.appendChild(etiquetaEstado);
            tarjeta.appendChild(filaEstado);

            const etiquetaSelect = crearTexto(
                'label',
                'Actualizar estado',
                'mt-4 block text-sm font-bold'
            );

            const selector = document.createElement('select');
            selector.className =
                'mt-2 w-full rounded-xl border border-stone-300 bg-white px-4 py-3';

            selector.setAttribute('aria-label', `Estado del pedido ${pedido.id}`);

            ['Pendiente', 'En preparación', 'Entregado']
                .forEach((estado) => {
                    const opcion = document.createElement('option');
                    opcion.value = estado;
                    opcion.textContent = estado;
                    opcion.selected = estado === pedido.estado;
                    selector.appendChild(opcion);
                });

            etiquetaSelect.appendChild(selector);
            tarjeta.appendChild(etiquetaSelect);

            selector.addEventListener('change', () => {
                const pedidosActualizados = leerPedidos();
                const indice = pedidosActualizados.findIndex(
                    (elemento) => elemento.id === pedido.id
                );

                if (indice === -1) return;

                pedidosActualizados[indice].estado = selector.value;

                try {
                    guardarPedidos(pedidosActualizados);
                    mostrarPedidos();
                } catch {
                    alert('No se pudo guardar el cambio de estado.');
                }
            });

            listaPedidos.appendChild(tarjeta);
        });
    }

    mostrarPedidos();

    window.addEventListener('storage', (evento) => {
        if (evento.key === 'byteCrunchPedidos') {
            mostrarPedidos();
        }
    });
</script>
@endpush

