
<x-guest-layout>
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-orange-50 px-4 py-10 sm:px-6">

        <!-- Decoración del fondo -->
        <div class="pointer-events-none absolute -left-24 -top-24 h-64 w-64 rounded-full bg-orange-200/50 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-amber-200/50 blur-3xl"></div>

        <div class="relative w-full max-w-md">

            <!-- Marca del negocio -->
            <div class="mb-7 text-center">
                <a href="/"
                   class="inline-flex items-center gap-3 rounded-2xl text-2xl font-black tracking-tight text-amber-950 sm:text-3xl">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-950 text-2xl text-white shadow-lg">
                        B
                    </span>
                    <span>
                        BYTE <span class="text-orange-600">&amp;</span> CRUNCH
                    </span>
                </a>

                <p class="mt-3 text-sm text-stone-600">
                    El antojo que llega hasta tu puerta.
                </p>
            </div>

            <!-- Tarjeta de acceso -->
            <div class="rounded-3xl border border-orange-100 bg-white p-6 shadow-xl shadow-amber-950/5 sm:p-9">

                <div class="mb-7">
                    <span class="inline-flex rounded-full bg-orange-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-orange-800">
                        Área de acceso
                    </span>

                    <h1 class="mt-4 text-3xl font-black tracking-tight text-amber-950">
                        ¡Qué gusto verte!
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-stone-600">
                        Ingresa tus datos para continuar y administrar tu acceso a BYTE &amp; CRUNCH.
                    </p>
                </div>

                <!-- Mensaje de sesión -->
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')"
                />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Correo electrónico -->
                    <div>
                        <x-input-label
                            for="email"
                            value="Correo electrónico"
                            class="font-bold text-amber-950"
                        />

                        <x-text-input
                            id="email"
                            class="mt-2 block w-full rounded-xl border-orange-200 px-4 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="tu@correo.com"
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />
                    </div>

                    <!-- Contraseña -->
                    <div class="mt-5">
                        <x-input-label
                            for="password"
                            value="Contraseña"
                            class="font-bold text-amber-950"
                        />

                        <x-text-input
                            id="password"
                            class="mt-2 block w-full rounded-xl border-orange-200 px-4 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Ingresa tu contraseña"
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />
                    </div>

                    <!-- Recordar sesión -->
                    <div class="mt-5 flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-orange-300 text-orange-600 focus:ring-orange-500"
                        >

                        <label
                            for="remember_me"
                            class="ms-2 text-sm text-stone-600"
                        >
                            Recordar mi sesión
                        </label>
                    </div>

                    <!-- Acciones -->
                    <div class="mt-7 space-y-4">
                        <button
                            type="submit"
                            class="flex min-h-12 w-full items-center justify-center rounded-xl bg-amber-950 px-4 py-3 font-bold text-white shadow-md transition hover:bg-amber-900 focus:outline-2 focus:outline-offset-2 focus:outline-orange-600"
                        >
                            Iniciar sesión
                        </button>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-orange-700 transition hover:text-orange-900 hover:underline"
                                >
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        @endif
                    </div>
                </form>

                <div class="mt-7 border-t border-orange-100 pt-5 text-center">
                    <a
                        href="/"
                        class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-semibold text-stone-600 transition hover:bg-orange-50 hover:text-amber-950"
                    >
                        ← Volver al catálogo
                    </a>
                </div>
            </div>

            <!-- Pie de página -->
            <p class="mt-6 text-center text-xs text-stone-500">
                BYTE &amp; CRUNCH · Hecho para disfrutar cada antojo.
            </p>

        </div>
    </div>
</x-guest-layout>
