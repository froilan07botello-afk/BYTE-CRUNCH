<nav x-data="{ open: false }" class="bg-white/95 border-b border-stone-200/80 sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Marca y enlaces principales --}}
            <div class="flex items-center gap-8">
                <a
                    href="{{ (Auth::user()->rol ?? 'cliente') === 'admin' ? route('admin.pedidos.index') : route('catalogo.index') }}"
                    class="inline-flex items-center gap-2.5 group"
                >
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold tracking-wider uppercase bg-amber-100 text-amber-900 border border-amber-200/80">
                        BYTE &amp; CRUNCH
                    </span>
                </a>

                {{-- Navegación escritorio según rol --}}
                <div class="hidden sm:flex items-center gap-6 text-sm">
                    @if ((Auth::user()->rol ?? 'cliente') === 'admin')
                        <a
                            href="{{ route('admin.pedidos.index') }}"
                            class="py-1 font-medium transition {{ request()->routeIs('admin.pedidos.*') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-stone-600 hover:text-stone-900' }}"
                        >
                            Pedidos
                        </a>
                        <a
                            href="{{ route('admin.productos.listar') }}"
                            class="py-1 font-medium transition {{ request()->routeIs('admin.productos.*') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-stone-600 hover:text-stone-900' }}"
                        >
                            Productos
                        </a>
                    @else
                        <a
                            href="{{ route('catalogo.index') }}"
                            class="py-1 font-medium transition {{ request()->routeIs('catalogo.*') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-stone-600 hover:text-stone-900' }}"
                        >
                            Catálogo
                        </a>
                        <a
                            href="{{ route('pedidos.index') }}"
                            class="py-1 font-medium transition {{ request()->routeIs('pedidos.*') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-stone-600 hover:text-stone-900' }}"
                        >
                            Seguimiento
                        </a>
                    @endif
                </div>
            </div>

            {{-- Menú de usuario (escritorio) --}}
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-stone-200 bg-orange-50/50 hover:bg-orange-100/60 text-sm font-medium text-stone-700 transition cursor-pointer">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-stone-500" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Mi perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-600 hover:text-red-700"
                            >
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Botón menú móvil --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-stone-500 hover:text-stone-800 hover:bg-stone-100 transition cursor-pointer"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú responsive móvil --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-stone-200/80 bg-white">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @if ((Auth::user()->rol ?? 'cliente') === 'admin')
                <x-responsive-nav-link :href="route('admin.pedidos.index')" :active="request()->routeIs('admin.pedidos.*')">
                    Pedidos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.productos.listar')" :active="request()->routeIs('admin.productos.*')">
                    Productos
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('catalogo.index')" :active="request()->routeIs('catalogo.*')">
                    Catálogo
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')">
                    Seguimiento
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-3 pb-4 border-t border-stone-200/80 px-4">
            <div class="mb-3">
                <div class="font-medium text-sm text-stone-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-stone-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Mi perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-600"
                    >
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
