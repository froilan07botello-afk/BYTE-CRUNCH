<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-amber-50/50 text-stone-900">
        <div class="w-full max-w-md bg-white border border-stone-200/80 rounded-2xl shadow-sm p-7 sm:p-8">
            <div class="mb-5">
                <span class="inline-block text-xs font-semibold tracking-widest uppercase text-orange-600 mb-1">
                    BYTE &amp; CRUNCH
                </span>
                <h1 class="text-xl font-bold text-stone-900">Recuperar contraseña</h1>
                <p class="text-sm text-stone-500 mt-1.5 leading-relaxed">
                    Escribe tu correo y te enviaremos un enlace para restablecer tu contraseña.
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="email" value="Correo electrónico" class="text-stone-700 text-sm font-medium" />
                    <x-text-input id="email"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs" />
                </div>

                <button type="submit"
                    class="w-full py-2.5 px-4 rounded-xl bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold shadow-sm transition cursor-pointer">
                    Enviar enlace de recuperación
                </button>
            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="text-sm text-stone-600 hover:text-stone-900 transition">
                    Volver a iniciar sesión
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
{{--<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}
