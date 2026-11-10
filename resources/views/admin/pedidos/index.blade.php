@extends('layouts.app')

@section('titulo', 'Panel Administrativo | BYTE & CRUNCH')

@section('content')
<header class="border-b border-orange-100 bg-white shadow-sm">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="/" class="text-xl font-black text-amber-950">
            BYTE <span class="text-orange-600">&</span> CRUNCH <span class="ml-2 rounded-md bg-orange-100 px-2 py-1 text-xs font-bold text-orange-800">Admin</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="/" class="rounded-xl bg-amber-950 px-4 py-2 text-sm font-bold text-white hover:bg-amber-900">
                Ver Tienda / Catálogo
            </a>
        </div>
    </nav>
</header>

<main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 sm:py-12">
    <section class="mb-8">
        <h1 class="text-3xl font-black text-amber-950 sm:text-4xl">
            Panel de Administración de Pedidos
        </h1>
        <p class="mt-2 text-stone-600">
            Gestiona los pedidos entrantes y actualiza su estado en tiempo real.
        </p>
    </section>

    <!-- Resumen de estados -->
    <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <p class="text-sm font-semibold text-amber-900">Pendientes</p>
            <p class="mt-2 text-3xl font-black text-amber-950">{{ $totalPendientes }}</p>
        </article>
        <article class="rounded-2xl border border-orange-200 bg-orange-50 p-5 shadow-sm">
            <p class="text-sm font-semibold text-orange-900">En preparación</p>
            <p class="mt-2 text-3xl font-black text-orange-950">{{ $totalPreparacion }}</p>
        </article>
        <article class="rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm">
            <p class="text-sm font-semibold text-green-900">Entregados</p>
            <p class="mt-2 text-3xl font-black text-green-950">{{ $totalEntregados }}</p>
        </article>
    </section>

    <!-- Listado de Pedidos -->
    <section class="space-y-5">
        @if (session('success'))
            <div class="mb-5 rounded-xl bg-green-100 p-4 text-green-800 font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($pedidos as $pedido)
            <article class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 border-b border-orange-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-stone-500">Folio: #{{ $pedido->id }}</p>
                        <h2 class="mt-1 text-xl font-black text-amber-950 sm:text-2xl">
                            {{ $pedido->nombre_cliente }}
                        </h2>
                    </div>
                    <span class="rounded-full bg-amber-100 px-4 py-1.5 text-sm font-bold text-amber-900">
                        {{ $pedido->estado }}
                    </span>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm text-stone-600">
                    <div>
                        <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
                        <p class="mt-1"><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
                        @if ($pedido->referencia)
                            <p class="mt-1"><strong>Referencia:</strong> {{ $pedido->referencia }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-stone-500">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Productos del pedido -->
                <div class="mt-5 rounded-xl bg-stone-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-2">Productos solicitados:</p>
                    <ul class="space-y-2 text-sm text-stone-700">
                        @foreach ($pedido->detalles as $detalle)
                            <li class="flex items-center justify-between gap-3">
                                <span>{{ $detalle->nombre_producto }} x {{ $detalle->cantidad }}</span>
                                <span class="font-bold">${{ number_format((float) $detalle->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-lg font-black text-orange-600 border-t border-stone-200 pt-2 text-right">
                        Total: ${{ number_format((float) $pedido->total, 2) }}
                    </p>
                </div>

                <!-- Formulario para cambiar estado -->
                <form action="{{ route('admin.pedidos.actualizarEstado', $pedido) }}" method="POST" class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end border-t border-stone-100 pt-4">
                    @csrf
                    @method('PATCH')

                    <label for="estado-{{ $pedido->id }}" class="text-sm font-bold text-stone-700">
                        Cambiar estado:
                    </label>
                    <select id="estado-{{ $pedido->id }}" name="estado" class="rounded-xl border border-orange-200 p-2 text-sm bg-white focus:outline-2 focus:outline-orange-500">
                        <option value="Pendiente" {{ $pedido->estado === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="En preparación" {{ $pedido->estado === 'En preparación' ? 'selected' : '' }}>En preparación</option>
                        <option value="Entregado" {{ $pedido->estado === 'Entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>

                    <button type="submit" class="rounded-xl bg-orange-600 px-4 py-2 text-sm font-bold text-white hover:bg-orange-700 transition">
                        Actualizar
                    </button>
                </form>
            </article>
        @empty
            <p class="rounded-2xl border border-orange-200 bg-white p-6 text-center text-stone-600">
                No hay pedidos registrados en el sistema.
            </p>
        @endforelse
    </section>
</main>
@endsection
