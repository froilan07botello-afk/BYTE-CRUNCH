@extends('layouts.app')

@section('titulo', 'Administración de Productos | BYTE & CRUNCH')

@section('content')
<header class="border-b border-orange-100 bg-white shadow-sm">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="/" class="text-xl font-black text-amber-950">
            BYTE <span class="text-orange-600">&</span> CRUNCH <span class="ml-2 rounded-md bg-orange-100 px-2 py-1 text-xs font-bold text-orange-800">Admin</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pedidos.index') }}" class="rounded-xl border border-stone-300 px-4 py-2 text-sm font-bold text-stone-700 hover:bg-stone-100">
                Ver Pedidos
            </a>
            <a href="/" class="rounded-xl bg-amber-950 px-4 py-2 text-sm font-bold text-white hover:bg-amber-900">
                Ver Tienda
            </a>
        </div>
    </nav>
</header>

<main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black text-amber-950 sm:text-4xl">
                Catálogo de Productos
            </h1>
            <p class="mt-2 text-stone-600">
                Administra los churros disponibles en la tienda, sus precios y descripciones.
            </p>
        </div>
        <a href="{{ route('admin.productos.nuevo') }}" class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-5 py-3 font-bold text-white shadow-sm transition hover:bg-orange-700">
            + Nuevo Churro
        </a>
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
