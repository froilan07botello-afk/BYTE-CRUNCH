@extends('layouts.app')

@section('titulo', 'Nuevo Churro | BYTE & CRUNCH')

@section('content')
<header class="border-b border-orange-100 bg-white shadow-sm">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="/" class="text-xl font-black text-amber-950">
            BYTE <span class="text-orange-600">&</span> CRUNCH <span class="ml-2 rounded-md bg-orange-100 px-2 py-1 text-xs font-bold text-orange-800">Admin</span>
        </a>
        <a href="{{ route('admin.productos.listar') }}" class="text-sm font-bold text-amber-950 hover:underline">
            &larr; Volver al catálogo
        </a>
    </nav>
</header>

<main class="mx-auto max-w-2xl px-4 py-8 sm:px-6 sm:py-12">
    <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="text-2xl font-black text-amber-950 sm:text-3xl">
            Agregar Nuevo Churro
        </h1>
        <p class="mt-1 text-sm text-stone-600 mb-6">
            Ingresa la información del churro para darlo de alta en MySQL.
        </p>

        <form action="{{ route('admin.productos.guardar') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nombre" class="mb-2 block text-sm font-bold text-stone-700">Nombre del producto *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:outline-2 focus:outline-orange-500" placeholder="Ej. Churro con Nutella">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="mb-2 block text-sm font-bold text-stone-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:outline-2 focus:outline-orange-500" placeholder="Ej. Delicioso churro crujiente relleno de cremosa Nutella.">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="precio" class="mb-2 block text-sm font-bold text-stone-700">Precio ($ MXN) *</label>
                <input type="number" step="0.50" id="precio" name="precio" value="{{ old('precio') }}" required class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:outline-2 focus:outline-orange-500" placeholder="35.00">
                @error('precio')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.productos.listar') }}" class="rounded-xl px-5 py-3 text-sm font-bold text-stone-600 hover:bg-stone-100">
                    Cancelar
                </a>
                <button type="submit" class="rounded-xl bg-orange-600 px-6 py-3 font-bold text-white transition hover:bg-orange-700">
                    Guardar Churro
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
