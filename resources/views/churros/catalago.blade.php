@extends('layouts.app')
@section('titulo', 'Catálogo | BYTE & CRUNCH')
@section('content')

    <!-- ENCABEZADO -->
    <header class="border-b border-orange-100 bg-white">
    <nav class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-x-3 gap-y-3 px-4 py-3 sm:flex-nowrap sm:px-6 sm:py-4">

        <!-- Nombre del negocio -->
        <a href="/"
           class="shrink-0 text-lg font-black tracking-tight text-amber-950 sm:text-2xl">
            BYTE <span class="text-orange-600">&amp;</span> CRUNCH
        </a>

        <!-- Navegación y carrito -->
        <div class="flex flex-wrap items-center justify-end gap-2 sm:gap-3">

            <a href="/seguimiento"
               class="inline-flex min-h-10 items-center justify-center rounded-xl px-2 py-2 text-sm font-bold text-amber-950 transition hover:bg-orange-50 sm:px-3">
                Seguimiento
            </a>

            <button
                type="button"
                id="ver-pedido"
                class="inline-flex min-h-10 items-center justify-center rounded-xl bg-amber-950 px-3 py-2 text-sm font-bold text-white transition hover:bg-amber-900 focus:outline-2 focus:outline-offset-2 focus:outline-orange-600 sm:px-4"
            >
                Mi pedido (<span id="cantidad-carrito">0</span>)
            </button>

        </div>
    </nav>
</header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12">

        <!-- PRESENTACIÓN -->
        <section class="mb-10 rounded-3xl bg-amber-950
                        px-6 py-10 text-white sm:px-10 sm:py-14">

            <p class="mb-3 text-sm font-bold uppercase
                      tracking-[0.2em] text-orange-300">
                Hechos para disfrutar
            </p>

            <h1 class="max-w-2xl text-3xl font-black
                       leading-tight sm:text-5xl">
                Un antojo dulce merece un gran churro.
            </h1>

            <p class="mt-4 max-w-xl text-sm leading-6
                      text-orange-100 sm:text-base">
                Descubre nuestros churros rellenos, preparados
                para darle un toque dulce a tu día.
            </p>

            <a href="#catalogo"
               class="mt-6 inline-flex min-h-12 items-center
                      justify-center rounded-xl bg-orange-500
                      px-6 py-3 font-bold text-white
                      transition hover:bg-orange-600">
                Ver catálogo
            </a>
        </section>

        <!-- CATÁLOGO -->
        <section id="catalogo">

            <div class="mb-6">
                <p class="text-sm font-bold uppercase
                          tracking-widest text-orange-700">
                    Nuestro menú
                </p>

                <h2 class="mt-2 text-2xl font-black
                           sm:text-3xl">
                    Elige tu favorito
                </h2>

                <p class="mt-2 text-sm text-stone-600">
                    Selecciona tus churros y arma tu pedido.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2
                        lg:grid-cols-3">

                <!-- PRODUCTOS QUE VIENEN DE NUESTRA BD -->
                <!-- RECORRE CADA DATO DE LA BD Y LO TRAE PARA MOSTRARLO EN LA VISTA
                    MEDIANTE EL CICLO FOR ELSE-->
                @forelse ($productos as $producto)
                <x-tarjeta-producto
                    :id="$producto->id"
                    :nombre="$producto->nombre"
                    :descripcion="$producto->descripcion ?? 'Un delicioso churro preparado para disfrutar.'"
                    :precio="$producto->precio"
                    :emoji="'🍩'"
                />
             @empty
                <p class="col-span-full rounded-2xl bg-white p-6 text-center text-stone-600">
                    Por el momento no hay churros disponibles.
                </p>
             @endforelse

            </div>
        </section>

        <!-- MENSAJE DE INTERACCIÓN -->
        <div id="mensaje"
             class="mt-6 hidden rounded-xl border
                    border-green-200 bg-green-50 p-4
                    text-sm font-medium text-green-800"
             role="status"
             aria-live="polite">
        </div>

        <!-- RESUMEN TEMPORAL DEL PEDIDO -->
        <section id="resumen"
                 class="mt-8 hidden rounded-2xl
                        border border-orange-200 bg-white p-5">

            <h2 class="text-xl font-black">
                Tu selección
            </h2>

            <ul id="lista-pedido"
                class="mt-4 space-y-3">
            </ul>

            <div class="mt-5 flex items-center
                        justify-between border-t
                        border-stone-200 pt-4">

                <span class="font-bold">Subtotal</span>

                <span id="subtotal"
                      class="text-xl font-black">
                    $0.00
                </span>
            </div>

            <p class="mt-3 text-xs text-stone-500">
                el subtotal no incluye entrega.

            </p>
        </section>


<!-- Formulario para completar el pedido -->
<section id="formulario-pedido"
    class="mt-8 hidden rounded-2xl border border-orange-200 bg-white p-6">

    <h2 class="text-2xl font-black text-amber-950">
        Completa tu pedido
    </h2>

    <p class="mt-2 text-sm text-stone-600">
        Déjanos tus datos para preparar tu pedido.
    </p>
    <form id="form-pedido" action="{{ route('pedidos.store') }}" method="POST" class="mt-6 space-y-5">
    @csrf
        <div>
            <label for="nombre-cliente" class="mb-2 block text-sm font-bold">
            Nombre completo
            </label>
            <input
                id="nombre-cliente"
                name="nombre_cliente"
                type="text"
                required
                maxlength="100"
                autocomplete="name"
                value="{{ old('nombre_cliente') }}"
                class="w-full rounded-xl border border-stone-300 px-4 py-3 focus:outline-2 focus:outline-orange-500"
            >
            @error('nombre_cliente')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
             <label for="telefono-cliente" class="mb-2 block text-sm font-bold">
                Teléfono de contacto
            </label>
             <input
                id="telefono-cliente"
                name="telefono"
                type="tel"
                required
                maxlength="20"
                autocomplete="tel"
                value="{{ old('telefono') }}"
                class="w-full rounded-xl border border-stone-300 px-4 py-3 focus:outline-2 focus:outline-orange-500"
            >
        </div>
         @error('telefono')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <div>
             <label for="direccion-cliente" class="mb-2 block text-sm font-bold">
                Dirección de entrega
             </label>
        <textarea
            id="direccion-cliente"
            name="direccion"
            required
            maxlength="250"
            rows="3"
            autocomplete="street-address"
            class="w-full rounded-xl border border-stone-300 px-4 py-3 focus:outline-2 focus:outline-orange-500"
        >{{ old('direccion') }}</textarea>
        @error('direccion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        </div>

         <div>
            <label for="referencia-cliente" class="mb-2 block text-sm font-bold">
                Referencias para llegar (opcional)
            </label>
            <input
                id="referencia-cliente"
                name="referencia"
                type="text"
                maxlength="200"
                placeholder="Ej. Casa junto a la tienda"
                value="{{ old('referencia') }}"
                class="w-full rounded-xl border border-stone-300 px-4 py-3 focus:outline-2 focus:outline-orange-500"
            >
            @error('referencia')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div id="productos-ocultos"></div>

            @error('productos')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button
                type="submit"
                class="w-full rounded-xl bg-orange-500 px-6 py-4 font-bold text-white transition hover:bg-orange-600"
            >
                Confirmar pedido
            </button>
    </form>
</section>

<!-- Confirmación de demostración -->
<section id="confirmacion-pedido"
    class="mt-8 hidden rounded-2xl border border-green-200 bg-green-50 p-6"
    role="status" aria-live="polite">

    <h2 class="text-2xl font-black text-green-900">
        ¡Pedido registrado!!
    </h2>

    <p id="mensaje-confirmacion"
        class="mt-3 text-green-900"></p>

    <p class="mt-4 font-bold text-green-900">
        Estado: <span id="estado-pedido">Pendiente</span>
    </p>

</section>

    </main>

    <footer class="mt-12 border-t border-orange-100
                   bg-white px-4 py-6 text-center
                   text-sm text-stone-500">
        © BYTE & CRUNCH
    </footer>

    <!-- INTERACCIÓN TEMPORAL EN EL NAVEGADOR -->
    <script>
        const carrito = [];
        const cantidadCarrito =
            document.getElementById('cantidad-carrito');
        const mensaje = document.getElementById('mensaje');
        const resumen = document.getElementById('resumen');
        const listaPedido = document.getElementById('lista-pedido');
        const subtotalElemento = document.getElementById('subtotal');
        const formularioPedido = document.getElementById('formulario-pedido');
        const formulario = document.getElementById('form-pedido');
        const confirmacion = document.getElementById('confirmacion-pedido');
        const mensajeConfirmacion = document.getElementById('mensaje-confirmacion');

        function dinero(cantidad) {
            return cantidad.toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });
        }

        function actualizarCarrito() {
            const cantidadTotal = carrito.reduce(
                (total, producto) => total + producto.cantidad,
                0
            );

            const subtotal = carrito.reduce(
                (total, producto) =>
                    total + producto.precio * producto.cantidad,
                0
            );

            cantidadCarrito.textContent = cantidadTotal;
            listaPedido.replaceChildren();

            carrito.forEach((producto) => {
                const elemento = document.createElement('li');
                elemento.className =
                    'flex items-center justify-between gap-3 text-sm';

                const nombre = document.createElement('span');
                nombre.textContent =
                    `${producto.nombre} × ${producto.cantidad}`;

                const precio = document.createElement('span');
                precio.className = 'font-bold';
                precio.textContent =
                    dinero(producto.precio * producto.cantidad);

                elemento.append(nombre, precio);
                listaPedido.appendChild(elemento);
            });

            subtotalElemento.textContent = dinero(subtotal);
            resumen.classList.toggle('hidden', carrito.length === 0);
            formularioPedido.classList.toggle('hidden', carrito.length === 0);
        }

        document.querySelectorAll('[data-agregar]').forEach((boton) => {
            boton.addEventListener('click', () => {
                const id= Number(boton.dataset.productoId);
                const nombre = boton.dataset.producto;
                const precio = Number(boton.dataset.precio);

                 if (!Number.isInteger(id) || id <= 0 ||
                    !nombre || !Number.isFinite(precio) || precio <= 0) {
                    return;
                    }

                const existente = carrito.find(
                    producto => producto.id === id
                );

                if (existente) {
                    existente.cantidad++;
                } else {
                    carrito.push({
                        id,
                        nombre,
                        precio,
                        cantidad: 1
                    });
                }

                actualizarCarrito();

                mensaje.textContent =
                    `${nombre} se agregó a tu pedido.`;
                mensaje.classList.remove('hidden');
            });
        });

        document.getElementById('ver-pedido')
            .addEventListener('click', () => {
                if (carrito.length === 0) {
                    mensaje.textContent =
                        'Tu pedido está vacío. ¡Agrega un churro para comenzar!';
                    mensaje.classList.remove('hidden');
                    return;
                }

                resumen.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });



        formulario.addEventListener('submit', (evento) => {
        if (carrito.length === 0) {
            evento.preventDefault();

            mensaje.textContent = 'Agrega un churro antes de confirmar.';
            mensaje.classList.remove('hidden');
            return;
        }

        const contenedorProductos = document.getElementById('productos-ocultos');

        // Eliminamos campos anteriores para evitar duplicados.
        contenedorProductos.replaceChildren();

        // Enviamos únicamente el ID y la cantidad de cada producto.
        carrito.forEach((producto, indice) =>
        {
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = `productos[${indice}][id]`;
            inputId.value = producto.id;

            const inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = `productos[${indice}][cantidad]`;
            inputCantidad.value = producto.cantidad;
            contenedorProductos.append(inputId, inputCantidad);
         });
     });
 </script>
