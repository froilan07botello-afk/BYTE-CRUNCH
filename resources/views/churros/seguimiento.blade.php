
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
            Consulta el estado de los pedidos de nuestros clientes
        </p>
    </section>


<section class="mb-8">
    <h2 class="mb-4 text-lg font-black text-amber-950">
        Resumen de pedidos
    </h2>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
            <p class="text-sm font-semibold text-amber-900">Pendientes</p>
            <p class="mt-2 text-3xl font-black text-amber-950">{{$totalPendientes}}</p>
        </article>

        <article class="rounded-2xl border border-orange-200 bg-orange-50 p-5">
            <p class="text-sm font-semibold text-orange-900">En preparación</p>
            <p class="mt-2 text-3xl font-black text-orange-950">
                {{ $totalPreparacion }}
            </p>
        </article>

        <article class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <p class="text-sm font-semibold text-green-900">Entregados</p>
            <p class="mt-2 text-3xl font-black text-green-950">
                {{ $totalEntregados }}
            </p>
        </article>
    </div>
</section>


<section id="lista-pedidos" class="space-y-5">

    @if (session('success'))
        <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif
    @forelse ($pedidos as $pedido) {{-- Recorremos pedidos de mysql --}}

        <article class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm">

            {{-- Información del pedido --}}
            <div class="flex flex-col gap-3 border-b border-orange-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-stone-500">
                        Pedido #{{ $pedido->id }}
                    </p>

                    <h2 class="mt-1 text-xl font-black text-amber-950 sm:text-2xl">
                        {{ $pedido->nombre_cliente }} {{-- Mostramos el nombre del cliente consultado desde la BD--}}
                    </h2>
                </div>

                <span class="rounded-full bg-amber-100 px-3 py-2 text-sm font-bold text-amber-900">
                    {{ $pedido->estado }}
                </span>

            </div>

            {{-- Datos del cliente --}}
            <p class="mt-3 text-sm text-stone-600">
                Teléfono: {{ $pedido->telefono }}
            </p>

            <p class="mt-1 text-sm text-stone-600">
                Dirección: {{ $pedido->direccion }}
            </p>

            @if ($pedido->referencia)
                <p class="mt-1 text-sm text-stone-600">
                    Referencia: {{ $pedido->referencia }}
                </p>
            @endif

            {{-- Productos del pedido --}}
            <ul class="mt-4 space-y-2 text-sm text-stone-700">

                @foreach ($pedido->detalles as $detalle)

                    <li class="flex items-center justify-between gap-3">
                        <span>
                            {{ $detalle->nombre_producto }} × {{ $detalle->cantidad }}
                        </span>

                        <span class="font-bold">
                            ${{ number_format((float) $detalle->subtotal, 2) }}
                        </span>
                    </li>

                @endforeach

            </ul>

            {{-- Total --}}
            <p class="mt-4 text-lg font-black text-orange-600">
                Total: ${{ number_format((float) $pedido->total, 2) }} {{-- mostramos el total de compra
            </p>

            {{-- Fecha --}}
            <p class="mt-1 text-xs text-stone-500">
                Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}
                <form action="{{ route('pedidos.actualizarEstado', $pedido) }}" method="POST" class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center">
                    @csrf
                    @method('PATCH')

                    <label for="estado-{{ $pedido->id }}" class="font-semibold text-stone-700">
                        Actualizar estado:
                    </label>

                    <select
                        id="estado-{{ $pedido->id }}"
                        name="estado"
                        class="rounded-lg border border-orange-200 p-2"
                    >
                        <option value="Pendiente" {{ $pedido->estado === 'Pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>

                        <option value="En preparación" {{ $pedido->estado === 'En preparación' ? 'selected' : '' }}>
                            En preparación
                        </option>

                        <option value="Entregado" {{ $pedido->estado === 'Entregado' ? 'selected' : '' }}>
                            Entregado
                        </option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-orange-600 px-4 py-2 font-bold text-white hover:bg-orange-700"
                    >
                        Guardar estado
                    </button>
                </form>
            </p>

        </article>

    @empty

        <p class="rounded-xl border border-orange-200 bg-white p-6 text-center text-stone-600">
            Todavía no hay pedidos registrados.
        </p>

    @endforelse

</section>

</main>

@endsection

