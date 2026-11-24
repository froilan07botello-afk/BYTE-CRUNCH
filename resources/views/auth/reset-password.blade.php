<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-amber-50/50 text-stone-900">
        <div class="w-full max-w-md bg-white border border-stone-200/80 rounded-2xl shadow-sm p-7 sm:p-8">
            <div class="mb-6 text-center">
                <span class="inline-block text-xs font-semibold tracking-widest uppercase text-orange-600 mb-1">
                    BYTE &amp; CRUNCH
                </span>
                <h1 class="text-xl font-bold text-stone-900">Nueva contraseña</h1>
                <p class="text-sm text-stone-500 mt-1">Define una contraseña nueva para tu cuenta.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Token de restablecimiento -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Correo electrónico -->
                <div>
                    <x-input-label for="email" value="Correo electrónico" class="text-stone-700 text-sm font-medium" />
                    <x-text-input id="email"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="email"
                        name="email"
                        :value="old('email', $request->email)"
                        required
                        autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs" />
                </div>

                <!-- Nueva contraseña -->
                <div>
                    <x-input-label for="password" value="Contraseña" class="text-stone-700 text-sm font-medium" />
                    <x-text-input id="password"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs" />
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <x-input-label for="password_confirmation" value="Confirmar contraseña" class="text-stone-700 text-sm font-medium" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1.5 w-full rounded-xl border-stone-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs" />
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold shadow-sm transition cursor-pointer">
                        Restablecer contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
{{--<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}
