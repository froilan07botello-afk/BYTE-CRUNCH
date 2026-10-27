
@props([
    'nombre',
    'descripcion',
    'precio',
    'emoji' => '🍩',
])

<article class="flex flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
    <div class="flex h-32 items-center justify-center rounded-xl bg-orange-50 text-6xl" aria-hidden="true">
        {{ $emoji }}
    </div>

    <div class="flex flex-1 flex-col pt-4">
        <h3 class="text-xl font-black text-amber-950">
            {{ $nombre }}
        </h3>

        <p class="mt-2 flex-1 text-sm leading-6 text-stone-600">
            {{ $descripcion }}
        </p>

        <div class="mt-5 flex items-center justify-between gap-3">
            <span class="text-xl font-black text-orange-600">
                ${{ number_format((float) $precio, 2) }}
            </span>

            <button
                type="button"
                data-agregar
                data-producto="{{ $nombre }}"
                data-precio="{{ $precio }}"
                class="min-h-11 rounded-xl bg-amber-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-amber-900 focus:outline-2 focus:outline-offset-2 focus:outline-orange-600"
            >
                Agregar
            </button>
        </div>
    </div>
</article>

