
<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-amber-50/50 text-stone-900">
        <div class="w-full max-w-md bg-white border border-stone-200/80 rounded-2xl shadow-sm p-7 sm:p-8">
            <!-- Encabezado -->
            <div class="mb-6 text-center">
                <span class="inline-block text-xs font-semibold tracking-widest uppercase text-orange-600 mb-1">
                    BYTE &amp; CRUNCH
                </span>
                <h1 class="text-2xl font-bold text-stone-900">Iniciar sesión</h1>
                <p class="text-sm text-stone-500 mt-1">Accede a tu cuenta para continuar.</p>
            </div>

            <!-- Estado de sesión -->
            <x-auth-session-status class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Correo electrónico -->
                <div>
                    <x-input-label for="email" value="Correo electrónico" class="text-stone-700 text-sm font-medium" />
                    <x-text-input id="email"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs" />
                </div>

                <!-- Contraseña -->
                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" value="Contraseña" class="text-stone-700 text-sm font-medium" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-orange-700 hover:text-orange-800 transition">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <x-text-input id="password"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs" />
                </div>

                <!-- Recordarme -->
                <div class="flex items-center pt-1">
                    <input id="remember_me"
                        type="checkbox"
                        class="rounded border-stone-300 text-orange-600 focus:ring-orange-500"
                        name="remember">
                    <label for="remember_me" class="ms-2 text-sm text-stone-600">
                        Recordar sesión
                    </label>
                </div>

                <!-- Botón principal -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-orange-600 hover:bg-orange-700 active:bg-orange-800 text-white text-sm font-semibold shadow-sm transition cursor-pointer">
                        Entrar
                    </button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="mt-6 pt-5 border-t border-stone-100 text-center text-sm text-stone-600">
                    ¿Aún no tienes cuenta?
                    <a href="{{ route('register') }}" class="font-semibold text-orange-700 hover:text-orange-800 ml-1">
                        Crear cuenta
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
