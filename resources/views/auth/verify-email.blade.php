<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-amber-50/50 text-stone-900">
        <div class="w-full max-w-md bg-white border border-stone-200/80 rounded-2xl shadow-sm p-7 sm:p-8">
            <div class="mb-5">
                <span class="inline-block text-xs font-semibold tracking-widest uppercase text-orange-600 mb-1">
                    BYTE &amp; CRUNCH
                </span>
                <h1 class="text-xl font-bold text-stone-900">Confirmar contraseña</h1>
                <p class="text-sm text-stone-500 mt-1.5 leading-relaxed">
                    Esta es una zona segura. Confirma tu contraseña antes de continuar.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="password" value="Contraseña" class="text-stone-700 text-sm font-medium" />
                    <x-text-input id="password"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs" />
                </div>

                <button type="submit"
                    class="w-full py-2.5 px-4 rounded-xl bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold shadow-sm transition cursor-pointer">
                    Confirmar
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
{{--<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
--}}
