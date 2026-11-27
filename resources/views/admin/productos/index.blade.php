@extends('layouts.app')

@section('titulo', 'Administración de Productos | BYTE & CRUNCH')

@section('content')
<header class="border-b border-orange-100 bg-white shadow-sm">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ route('admin.pedidos.index') }}" class="text-xl font-black text-amber-950">
            BYTE <span class="text-orange-600">&</span> CRUNCH
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pedidos.index') }}" class="rounded-xl border border-stone-300 px-4 py-2 text-sm font-bold text-stone-700 hover:bg-stone-100">
                Ver Pedidos
            </a>

        </div>
    </nav>
</header>

<main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black text-amber-950 sm:text-4xl">
                Catálogo de Productos
            </h1>
            <p class="mt-2 text-sm text-stone-600">
                Administra precios, descripciones y disponibilidad inmediata en el menú.
            </p>
        </div>
        <a href="{{ route('admin.productos.nuevo') }}" class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-5 py-3 font-bold text-white shadow-sm transition hover:bg-orange-700">
            + Nuevo Churro
        </a>
    </div>

    <!-- Barra de filtros rápidos de productos -->
    <div class="mb-6 flex flex-col gap-3 rounded-2xl border border-orange-100 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.productos.listar', array_filter(['buscar' => $busqueda !== '' ? $busqueda : null])) }}"
               class="rounded-xl px-3.5 py-2 text-xs font-bold transition {{ $filtroDisponibilidad === 'todos' ? 'bg-amber-950 text-white' : 'bg-orange-50 text-amber-950 hover:bg-orange-100' }}">
                Todos ({{ $totalDisponibles + $totalNoDisponibles }})
            </a>
            <a href="{{ route('admin.productos.listar', array_filter(['disponibilidad' => 'disponibles', 'buscar' => $busqueda !== '' ? $busqueda : null])) }}"
               class="rounded-xl px-3.5 py-2 text-xs font-bold transition {{ $filtroDisponibilidad === 'disponibles' ? 'bg-green-700 text-white' : 'bg-green-50 text-green-800 hover:bg-green-100' }}">
                Disponibles ({{ $totalDisponibles }})
            </a>
            <a href="{{ route('admin.productos.listar', array_filter(['disponibilidad' => 'agotados', 'buscar' => $busqueda !== '' ? $busqueda : null])) }}"
               class="rounded-xl px-3.5 py-2 text-xs font-bold transition {{ $filtroDisponibilidad === 'agotados' ? 'bg-stone-700 text-white' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                No disponibles ({{ $totalNoDisponibles }})
            </a>
        </div>

        <form method="GET" action="{{ route('admin.productos.listar') }}" class="flex items-center gap-2">
            @if ($filtroDisponibilidad !== 'todos')
                <input type="hidden" name="disponibilidad" value="{{ $filtroDisponibilidad }}">
            @endif
            <input
                type="text"
                name="buscar"
                value="{{ $busqueda }}"
                placeholder="Buscar churro..."
                class="w-full sm:w-52 rounded-xl border border-stone-300 px-3.5 py-2 text-sm text-stone-900 focus:border-orange-500 focus:outline-2 focus:outline-orange-500"
            >
            <button type="submit" class="cursor-pointer rounded-xl bg-orange-600 px-3.5 py-2 text-xs font-bold text-white hover:bg-orange-700">
                Buscar
            </button>
            @if ($busqueda !== '' || $filtroDisponibilidad !== 'todos')
                <a href="{{ route('admin.productos.listar') }}" class="rounded-xl border border-stone-300 px-3 py-2 text-xs font-bold text-stone-600 hover:bg-stone-100">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-100 p-4 text-green-800 font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-orange-100 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-stone-700">
            <thead class="border-b border-orange-100 bg-orange-50 text-xs uppercase text-amber-950">
                <tr>
                    <th scope="col" class="px-6 py-4 font-black">ID</th>
                    <th scope="col" class="px-6 py-4 font-black">Nombre</th>
                    <th scope="col" class="px-6 py-4 font-black">Descripción</th>
                    <th scope="col" class="px-6 py-4 font-black">Precio</th>
                    <th scope="col" class="px-6 py-4 font-black">Estado</th>
                    <th scope="col" class="px-6 py-4 font-black text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse ($productos as $producto)
                    <tr class="hover:bg-orange-50/50">
                        <td class="whitespace-nowrap px-6 py-4 font-bold text-stone-500">
                            #{{ $producto->id }}
                        </td>
                        <td class="px-6 py-4 font-bold text-amber-950">
                            {{ $producto->nombre }}
                        </td>
                        <td class="px-6 py-4 text-xs text-stone-600 max-w-xs truncate">
                            {{ $producto->descripcion ?? 'Sin descripción' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-black text-orange-600">
                            ${{ number_format((float) $producto->precio, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($producto->disponible)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">
                                    Disponible
                                </span>
                            @else
                                <span class="rounded-full bg-stone-200 px-3 py-1 text-xs font-bold text-stone-600">
                                    No disponible
                                </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.productos.editar', $producto) }}" class="rounded-lg border border-orange-200 bg-white px-3 py-1.5 text-xs font-bold text-amber-950 transition hover:bg-orange-100">
                                    Editar
                                </a>

                                <form action="{{ route('admin.productos.disponibilidad', $producto) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-bold text-white transition {{ $producto->disponible ? 'bg-amber-950 hover:bg-amber-900' : 'bg-green-600 hover:bg-green-700' }}">
                                        {{ $producto->disponible ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-stone-500">
                            No hay productos registrados en la base de datos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
