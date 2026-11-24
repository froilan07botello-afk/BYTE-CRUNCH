<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6">
            <div class="mb-2">
                <h1 class="text-xl font-semibold text-stone-900">Mi perfil</h1>
                <p class="text-sm text-stone-500 mt-0.5">
                    Administra tus datos personales y la seguridad de tu cuenta.
                </p>
            </div>

            <div class="bg-white border border-stone-200/80 rounded-2xl shadow-sm p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white border border-stone-200/80 rounded-2xl shadow-sm p-6">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white border border-stone-200/80 rounded-2xl shadow-sm p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
