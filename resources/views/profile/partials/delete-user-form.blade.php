<section class="space-y-4">
    <header>
        <h3 class="text-base font-semibold text-stone-900">
            Eliminar cuenta
        </h3>
        <p class="text-sm text-stone-500 mt-0.5">
            Una vez eliminada tu cuenta, sus datos se borrarán de forma permanente.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 transition cursor-pointer"
    >
        Eliminar cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h3 class="text-base font-semibold text-stone-900">
                ¿Seguro que deseas eliminar tu cuenta?
            </h3>

            <p class="mt-1.5 text-sm text-stone-500">
                Ingresa tu contraseña para confirmar la eliminación definitiva de tu cuenta.
            </p>

            <div class="mt-4">
                <label for="delete_password" class="sr-only">Contraseña</label>
                <input
                    id="delete_password"
                    name="password"
                    type="password"
                    placeholder="Contraseña"
                    class="w-full sm:w-3/4 rounded-xl border-stone-300 text-sm text-stone-900 focus:border-orange-500 focus:ring-orange-500"
                />
                @error('password', 'userDeletion')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-2.5">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="rounded-xl border border-stone-300 bg-white hover:bg-stone-50 text-stone-700 text-sm font-medium px-4 py-2 transition cursor-pointer"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 transition cursor-pointer"
                >
                    Eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>
{{--<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>--}}
