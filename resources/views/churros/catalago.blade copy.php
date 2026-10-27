
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BYTE & CRUNCH | Churros rellenos</title>
    <meta name="description"
          content="Descubre los churros rellenos de BYTE & CRUNCH.">

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-orange-50 text-stone-900">

    <!-- ENCABEZADO -->
    <header class="border-b border-orange-100 bg-white">
        <nav class="mx-auto flex max-w-6xl items-center
                    justify-between gap-3 px-4 py-4 sm:px-6">

            <a href="/" class="text-lg font-black tracking-tight
                               text-amber-950 sm:text-2xl">
                BYTE <span class="text-orange-600">&</span> CRUNCH
            </a>

            <button
                type="button"
                id="ver-pedido"
                class="rounded-xl bg-amber-950 px-4 py-3
                       text-sm font-bold text-white
                       transition hover:bg-amber-900
                       focus:outline-2 focus:outline-offset-2
                       focus:outline-orange-600"
            >
                Mi pedido (<span id="cantidad-carrito">0</span>)
            </button>
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


            <x-tarjeta-producto
                nombre="Churro de cajeta"
                descripcion="Crujiente por fuera, suave por dentro y relleno de dulce de leche."
                precio="25"
                emoji="🍯"
             />

            <x-tarjeta-producto
                nombre="Churro de chocolate"
                descripcion="Una opción dulce con un delicioso relleno de chocolate."
                precio="30"
                emoji="🍫"
            />

            <x-tarjeta-producto
                nombre="Churro especial"
                descripcion="Un antojo especial para disfrutar de un sabor diferente."
                precio="35"
                emoji="✨"
            />


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
        }

        document.querySelectorAll('[data-agregar]').forEach((boton) => {
            boton.addEventListener('click', () => {
                const nombre = boton.dataset.producto;
                const precio = Number(boton.dataset.precio);

                if (!nombre || !Number.isFinite(precio) || precio <= 0) {
                    return;
                }

                const existente = carrito.find(
                    producto => producto.nombre === nombre
                );

                if (existente) {
                    existente.cantidad++;
                } else {
                    carrito.push({
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
    </script>

</body>
</html>
