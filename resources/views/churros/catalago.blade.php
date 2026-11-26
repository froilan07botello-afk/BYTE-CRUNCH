@extends('layouts.app')
@section('titulo', 'Catálogo | BYTE & CRUNCH')
@section('content')

    <!-- ENCABEZADO -->
    <header class="border-b border-orange-100 bg-white">
    <nav class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-x-3 gap-y-3 px-4 py-3 sm:flex-nowrap sm:px-6 sm:py-4">

        <!-- Nombre del negocio -->
        <a href="{{ route('catalogo.index') }}"
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
            @auth
                        <div class="flex flex-wrap items-center gap-2.5 sm:border-l sm:border-stone-200 sm:pl-4">
                <span class="rounded-full bg-orange-100 px-3 py-1.5 text-xs font-bold text-stone-800">
                    {{ auth()->user()->name }}
                </span>

                <a href="{{ route('profile.edit') }}"
                class="inline-flex h-9 items-center justify-center rounded-xl border border-stone-300 bg-white px-3.5 text-xs font-bold text-stone-700 transition hover:bg-stone-100">
                    Mi Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}" class="m-0 inline-flex items-center">
                    @csrf
                    <button type="submit"
                            class="inline-flex h-9 cursor-pointer items-center justify-center rounded-xl bg-red-600 px-3.5 text-xs font-bold text-white transition hover:bg-red-700">
                        Cerrar sesión
                    </button>
                </form>
            </div>
            @endauth

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
                    :emoji="''"
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
                        border border-orange-200 bg-white p-5 sm:p-6">

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-black text-amber-950">
                    Tu selección
                </h2>

                <button
                    type="button"
                    id="vaciar-carrito"
                    class="cursor-pointer rounded-lg border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700"
                >
                    Vaciar pedido
                </button>
            </div>

            <ul id="lista-pedido"
                class="mt-4 divide-y divide-stone-100">
            </ul>

            <div class="mt-5 flex items-center
                        justify-between border-t
                        border-stone-200 pt-4">

                <span class="font-bold text-stone-800">Subtotal</span>

                <span id="subtotal"
                      class="text-xl font-black text-orange-600">
                    $0.00
                </span>
            </div>

            <p class="mt-3 text-xs text-stone-500">
                El subtotal no incluye costo de entrega.
            </p>
        </section>


<!-- Formulario para completar el pedido -->
<section id="formulario-pedido"
    class="mt-8 hidden rounded-2xl border border-orange-200 bg-white p-6">
    <h2 class="text-2xl font-black text-amber-950">
        Completa tu pedido
    </h2>
    <p class="mt-2 text-sm text-stone-600">
        Déjanos tus datos para preparar y entregar tu pedido.
    </p>

    <form id="form-pedido" action="{{ route('pedidos.store') }}" method="POST" class="mt-6 space-y-5" novalidate>
        @csrf

        <!-- 1. Nombre completo -->
        <div>
            <label for="nombre-cliente" class="mb-2 block text-sm font-bold text-stone-800">
                Nombre completo
            </label>
            <input
                id="nombre-cliente"
                name="nombre_cliente"
                type="text"
                required
                minlength="3"
                maxlength="60"
                autocomplete="name"
                value="{{ old('nombre_cliente') }}"
                placeholder="Ej. María Elena López"
                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 focus:border-orange-500 focus:outline-2 focus:outline-orange-500"
            >
            <p id="error-nombre" class="mt-1.5 hidden text-sm text-red-600"></p>
            @error('nombre_cliente')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- 2. Teléfono de contacto (10 dígitos) -->
        <div>
            <label for="telefono-cliente" class="mb-2 block text-sm font-bold text-stone-800">
                Teléfono de contacto (10 dígitos)
            </label>
            <input
                id="telefono-cliente"
                name="telefono"
                type="tel"
                inputmode="numeric"
                required
                maxlength="20"
                autocomplete="tel"
                value="{{ old('telefono') }}"
                placeholder="Ej. 4331234567"
                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 focus:border-orange-500 focus:outline-2 focus:outline-orange-500"
            >
            <p id="error-telefono" class="mt-1.5 hidden text-sm text-red-600"></p>
            @error('telefono')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- 3. Dirección de entrega -->
        <div>
            <label for="direccion-cliente" class="mb-2 block text-sm font-bold text-stone-800">
                Dirección de entrega
            </label>
            <textarea
                id="direccion-cliente"
                name="direccion"
                required
                minlength="15"
                maxlength="255"
                rows="3"
                autocomplete="street-address"
                placeholder="Calle, número exterior o lote, colonia o barrio..."
                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 focus:border-orange-500 focus:outline-2 focus:outline-orange-500"
            >{{ old('direccion') }}</textarea>
            <div class="mt-1 flex items-center justify-between gap-2">
                <p id="error-direccion" class="hidden text-sm text-red-600"></p>
                <span id="contador-direccion" class="ml-auto text-xs text-stone-500">0 / 255</span>
            </div>
            @error('direccion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- 4. Referencias para llegar (opcional, máx. 200 caracteres) -->
        <div>
            <label for="referencia-cliente" class="mb-2 block text-sm font-bold text-stone-800">
                Referencias para llegar (opcional)
            </label>
            <input
                id="referencia-cliente"
                name="referencia"
                type="text"
                maxlength="200"
                placeholder="Ej. Portón café frente a la florería"
                value="{{ old('referencia') }}"
                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 focus:border-orange-500 focus:outline-2 focus:outline-orange-500"
            >
            <div class="mt-1 flex items-center justify-between gap-2">
                <p id="error-referencia" class="hidden text-sm text-red-600"></p>
                <span id="contador-referencia" class="ml-auto text-xs text-stone-500">0 / 200</span>
            </div>
            @error('referencia')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- 5. Método de pago: Efectivo o Transferencia -->
        <div class="rounded-xl border border-orange-100 bg-orange-50/50 p-4 space-y-3">
            <span class="block text-sm font-bold text-stone-800">
                Método de pago
            </span>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm font-medium text-stone-800 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                    <input
                        type="radio"
                        name="metodo_pago"
                        value="efectivo"
                        class="text-orange-600 focus:ring-orange-500"
                        {{ old('metodo_pago', 'efectivo') === 'efectivo' ? 'checked' : '' }}
                    >
                    <span>Efectivo</span>
                </label>

                <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm font-medium text-stone-800 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                    <input
                        type="radio"
                        name="metodo_pago"
                        value="transferencia"
                        class="text-orange-600 focus:ring-orange-500"
                        {{ old('metodo_pago') === 'transferencia' ? 'checked' : '' }}
                    >
                    <span>Transferencia</span>
                </label>
            </div>

            <div id="campo-referencia-pago" class="{{ old('metodo_pago') === 'transferencia' ? '' : 'hidden' }} pt-1">
                <label id="etiqueta-referencia-pago" for="referencia-pago" class="mb-1.5 block text-xs font-semibold text-stone-700">
                    Últimos 4 dígitos o folio de transferencia (opcional)
                </label>
                <input
                    id="referencia-pago"
                    name="referencia_pago"
                    type="text"
                    maxlength="100"
                    value="{{ old('referencia_pago') }}"
                    placeholder="Ej. 4821 o comprobante a tu nombre"
                    class="w-full rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm text-stone-900 focus:border-orange-500 focus:outline-2 focus:outline-orange-500"
                >
                @error('referencia_pago')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div id="productos-ocultos"></div>
        @error('productos')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <button
            type="submit"
            class="w-full cursor-pointer rounded-xl bg-orange-500 px-6 py-4 font-bold text-white transition hover:bg-orange-600"
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
    <!-- INTERACCIÓN DEL CARRITO EN EL NAVEGADOR -->
    <script>
        const MAX_CANTIDAD_PRODUCTO = 50;
        const carrito = [];
        const cantidadCarrito = document.getElementById('cantidad-carrito');
        const mensaje = document.getElementById('mensaje');
        const resumen = document.getElementById('resumen');
        const listaPedido = document.getElementById('lista-pedido');
        const subtotalElemento = document.getElementById('subtotal');
        const formularioPedido = document.getElementById('formulario-pedido');
        const formulario = document.getElementById('form-pedido');
        const btnVaciarCarrito = document.getElementById('vaciar-carrito');

        function dinero(cantidad) {
            return cantidad.toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });
        }

        function mostrarAviso(texto) {
            if (!mensaje) return;
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
        }

        function cambiarCantidad(id, delta) {
            const indice = carrito.findIndex((item) => item.id === id);
            if (indice === -1) return;

            const producto = carrito[indice];
            const nuevaCantidad = producto.cantidad + delta;

            if (nuevaCantidad <= 0) {
                carrito.splice(indice, 1);
                mostrarAviso(`${producto.nombre} se quitó de tu pedido.`);
            } else if (nuevaCantidad > MAX_CANTIDAD_PRODUCTO) {
                mostrarAviso(`Puedes pedir máximo ${MAX_CANTIDAD_PRODUCTO} unidades de ${producto.nombre}.`);
                return;
            } else {
                producto.cantidad = nuevaCantidad;
            }

            actualizarCarrito();
        }

        function eliminarProducto(id) {
            const indice = carrito.findIndex((item) => item.id === id);
            if (indice === -1) return;

            const [eliminado] = carrito.splice(indice, 1);
            actualizarCarrito();
            mostrarAviso(`${eliminado.nombre} se eliminó de tu pedido.`);
        }

        function actualizarCarrito() {
            const cantidadTotal = carrito.reduce(
                (total, producto) => total + producto.cantidad,
                0
            );

            const subtotal = carrito.reduce(
                (total, producto) => total + producto.precio * producto.cantidad,
                0
            );

            cantidadCarrito.textContent = cantidadTotal;
            listaPedido.replaceChildren();

            carrito.forEach((producto) => {
                const elemento = document.createElement('li');
                elemento.className = 'flex flex-col gap-3 py-3.5 sm:flex-row sm:items-center sm:justify-between';

                // Info del producto (nombre y precio unitario)
                const info = document.createElement('div');
                info.className = 'min-w-0';

                const nombre = document.createElement('p');
                nombre.className = 'text-sm font-bold text-stone-900';
                nombre.textContent = producto.nombre;

                const precioUnitario = document.createElement('p');
                precioUnitario.className = 'text-xs text-stone-500';
                precioUnitario.textContent = `${dinero(producto.precio)} c/u`;

                info.append(nombre, precioUnitario);

                // Controles (- cantidad +), subtotal del ítem y botón quitar
                const controles = document.createElement('div');
                controles.className = 'flex items-center justify-between gap-3 sm:justify-end';

                const grupoCantidad = document.createElement('div');
                grupoCantidad.className = 'inline-flex items-center rounded-xl border border-stone-200 bg-stone-50 p-0.5';

                const btnRestar = document.createElement('button');
                btnRestar.type = 'button';
                btnRestar.setAttribute('aria-label', `Disminuir cantidad de ${producto.nombre}`);
                btnRestar.className = 'flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg text-sm font-black text-stone-700 transition hover:bg-white hover:text-orange-600';
                btnRestar.textContent = '−';
                btnRestar.addEventListener('click', () => cambiarCantidad(producto.id, -1));

                const spanCantidad = document.createElement('span');
                spanCantidad.className = 'min-w-8 px-2 text-center text-sm font-bold text-stone-900';
                spanCantidad.textContent = producto.cantidad;

                const btnSumar = document.createElement('button');
                btnSumar.type = 'button';
                btnSumar.setAttribute('aria-label', `Aumentar cantidad de ${producto.nombre}`);
                btnSumar.className = 'flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg text-sm font-black text-stone-700 transition hover:bg-white hover:text-orange-600';
                btnSumar.textContent = '+';
                btnSumar.addEventListener('click', () => cambiarCantidad(producto.id, 1));

                grupoCantidad.append(btnRestar, spanCantidad, btnSumar);

                const precioTotalItem = document.createElement('span');
                precioTotalItem.className = 'min-w-20 text-right text-sm font-black text-stone-900';
                precioTotalItem.textContent = dinero(producto.precio * producto.cantidad);

                const btnEliminar = document.createElement('button');
                btnEliminar.type = 'button';
                btnEliminar.setAttribute('aria-label', `Quitar ${producto.nombre}`);
                btnEliminar.className = 'cursor-pointer rounded-lg px-2 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50';
                btnEliminar.textContent = 'Quitar';
                btnEliminar.addEventListener('click', () => eliminarProducto(producto.id));

                controles.append(grupoCantidad, precioTotalItem, btnEliminar);
                elemento.append(info, controles);
                listaPedido.appendChild(elemento);
            });

            subtotalElemento.textContent = dinero(subtotal);
            resumen.classList.toggle('hidden', carrito.length === 0);
            formularioPedido.classList.toggle('hidden', carrito.length === 0);
        }

        document.querySelectorAll('[data-agregar]').forEach((boton) => {
            boton.addEventListener('click', () => {
                const id = Number(boton.dataset.productoId);
                const nombre = boton.dataset.producto;
                const precio = Number(boton.dataset.precio);

                if (!Number.isInteger(id) || id <= 0 ||
                    !nombre || !Number.isFinite(precio) || precio <= 0) {
                    return;
                }

                const existente = carrito.find((producto) => producto.id === id);

                if (existente) {
                    if (existente.cantidad >= MAX_CANTIDAD_PRODUCTO) {
                        mostrarAviso(`Puedes pedir máximo ${MAX_CANTIDAD_PRODUCTO} unidades de ${nombre}.`);
                        return;
                    }
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
                mostrarAviso(`${nombre} se agregó a tu pedido.`);
            });
        });

        btnVaciarCarrito?.addEventListener('click', () => {
            if (carrito.length === 0) return;
            carrito.length = 0;
            actualizarCarrito();
            mostrarAviso('Se vació tu pedido.');
        });

        document.getElementById('ver-pedido')
            .addEventListener('click', () => {
                if (carrito.length === 0) {
                    mostrarAviso('Tu pedido está vacío. ¡Agrega un churro para comenzar!');
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
                mostrarAviso('Agrega un churro antes de confirmar.');
                return;
            }

            const contenedorProductos = document.getElementById('productos-ocultos');
            contenedorProductos.replaceChildren();

            carrito.forEach((producto, indice) => {
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
 <script>
(() => {
    const formPedido = document.getElementById('form-pedido');
    if (!formPedido) return;

    const inputNombre = document.getElementById('nombre-cliente');
    const inputTelefono = document.getElementById('telefono-cliente');
    const inputDireccion = document.getElementById('direccion-cliente');
    const inputReferencia = document.getElementById('referencia-cliente');
    const contadorDireccion = document.getElementById('contador-direccion');
    const contadorReferencia = document.getElementById('contador-referencia');

    const errorNombre = document.getElementById('error-nombre');
    const errorTelefono = document.getElementById('error-telefono');
    const errorDireccion = document.getElementById('error-direccion');
    const errorReferencia = document.getElementById('error-referencia');

    const radiosPago = formPedido.querySelectorAll('input[name="metodo_pago"]');
    const contenedorReferenciaPago = document.getElementById('campo-referencia-pago');
    const etiquetaReferenciaPago = document.getElementById('etiqueta-referencia-pago');
    const inputReferenciaPago = document.getElementById('referencia-pago');

    const regexNombre = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]+$/;
    const secuenciasInvalidas = ['0123456789', '1234567890', '9876543210', '0987654321'];

    function mostrarError(elementoError, mensaje) {
        if (!elementoError) return;
        if (mensaje) {
            elementoError.textContent = mensaje;
            elementoError.classList.remove('hidden');
        } else {
            elementoError.textContent = '';
            elementoError.classList.add('hidden');
        }
    }

    function actualizarContadores() {
        if (contadorDireccion && inputDireccion) {
            contadorDireccion.textContent = `${inputDireccion.value.length} / 255`;
        }
        if (contadorReferencia && inputReferencia) {
            contadorReferencia.textContent = `${inputReferencia.value.length} / 200`;
        }
    }

    function validarNombre() {
        const limpio = (inputNombre.value || '').trim();
        if (!limpio) {
            mostrarError(errorNombre, 'El nombre completo es obligatorio y no puede ir vacío.');
            return false;
        }
        if (limpio.length < 3) {
            mostrarError(errorNombre, 'Escribe al menos 3 caracteres en el nombre.');
            return false;
        }
        if (limpio.length > 60) {
            mostrarError(errorNombre, 'El nombre no puede exceder los 60 caracteres.');
            return false;
        }
        if (!regexNombre.test(limpio)) {
            mostrarError(errorNombre, 'Solo se permiten letras, acentos, ñ y espacios (sin números ni símbolos).');
            return false;
        }
        mostrarError(errorNombre, '');
        return true;
    }

    function normalizarTelefonoEnVista() {
        const soloDigitos = (inputTelefono.value || '').replace(/\D+/g, '').slice(0, 10);
        inputTelefono.value = soloDigitos;
        return soloDigitos;
    }

    function validarTelefono() {
        const digitos = normalizarTelefonoEnVista();
        if (!digitos) {
            mostrarError(errorTelefono, 'El teléfono de contacto es obligatorio.');
            return false;
        }
        if (digitos.length !== 10) {
            mostrarError(errorTelefono, 'El teléfono debe tener exactamente 10 dígitos.');
            return false;
        }
        if (/^(\d)\1{9}$/.test(digitos) || secuenciasInvalidas.includes(digitos)) {
            mostrarError(errorTelefono, 'Ingresa un número de teléfono real de 10 dígitos.');
            return false;
        }
        mostrarError(errorTelefono, '');
        return true;
    }

    function validarDireccion() {
        actualizarContadores();
        const limpia = (inputDireccion.value || '').trim();
        if (!limpia) {
            mostrarError(errorDireccion, 'La dirección de entrega es obligatoria.');
            return false;
        }
        if (limpia.length < 15) {
            mostrarError(errorDireccion, 'Escribe al menos 15 caracteres con calle, número y colonia.');
            return false;
        }
        if (limpia.length > 255) {
            mostrarError(errorDireccion, 'La dirección no puede superar los 255 caracteres.');
            return false;
        }
        if (!/\d/.test(limpia)) {
            mostrarError(errorDireccion, 'Incluye al menos un número (casa, lote o manzana) en la dirección.');
            return false;
        }
        mostrarError(errorDireccion, '');
        return true;
    }

    function validarReferencia() {
        actualizarContadores();
        const texto = inputReferencia.value || '';
        if (texto.length > 200) {
            mostrarError(errorReferencia, 'Las referencias no pueden superar los 200 caracteres.');
            return false;
        }
        mostrarError(errorReferencia, '');
        return true;
    }

    function actualizarMetodoPago() {
        const seleccionado = formPedido.querySelector('input[name="metodo_pago"]:checked')?.value || 'efectivo';
        if (!contenedorReferenciaPago) return;

        if (seleccionado === 'transferencia') {
            contenedorReferenciaPago.classList.remove('hidden');
            if (etiquetaReferenciaPago) {
                etiquetaReferenciaPago.textContent = 'Últimos 4 dígitos o folio de transferencia (opcional)';
            }
            if (inputReferenciaPago) {
                inputReferenciaPago.placeholder = 'Ej. 4821 o concepto de transferencia';
            }
        } else {
            contenedorReferenciaPago.classList.add('hidden');
            if (inputReferenciaPago) {
                inputReferenciaPago.value = '';
            }
        }
    }

    inputNombre?.addEventListener('blur', validarNombre);
    inputNombre?.addEventListener('input', () => {
        if (!errorNombre?.classList.contains('hidden')) validarNombre();
    });

    inputTelefono?.addEventListener('input', validarTelefono);
    inputTelefono?.addEventListener('blur', validarTelefono);

    inputDireccion?.addEventListener('input', validarDireccion);
    inputDireccion?.addEventListener('blur', validarDireccion);

    inputReferencia?.addEventListener('input', validarReferencia);
    inputReferencia?.addEventListener('blur', validarReferencia);

    radiosPago.forEach((radio) => {
        radio.addEventListener('change', actualizarMetodoPago);
    });

    formPedido.addEventListener('submit', (event) => {
        const nombreOk = validarNombre();
        const telefonoOk = validarTelefono();
        const direccionOk = validarDireccion();
        const referenciaOk = validarReferencia();

        if (!nombreOk || !telefonoOk || !direccionOk || !referenciaOk) {
            event.preventDefault();
        }
    }, true);

    actualizarContadores();
    actualizarMetodoPago();
})();
</script>
