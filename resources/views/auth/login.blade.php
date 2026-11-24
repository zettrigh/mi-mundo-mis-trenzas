@section('title', 'Iniciar Sesión')

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <div class="mb-4">
        <h1 class="font-serif-title text-xl sm:text-2xl font-bold text-stone-900 tracking-tight">Iniciar Sesión</h1>
        <p class="text-xs text-stone-500 mt-0.5">Ingresa tus datos para acceder a tu cuenta.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-xs" />
            <x-text-input id="email" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3" type="email" name="email" :value="old('email')" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mt-3">
            <x-input-label for="password" :value="__('Contraseña')" class="text-xs" />

            <x-password-input id="password" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3"
                               name="password"
                               autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-3 text-xs">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-pink-600 shadow-sm focus:ring-pink-600" name="remember">
                <span class="ms-2 text-stone-600">{{ __('Mantener sesión iniciada') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-stone-500 hover:text-pink-700" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div class="mt-4">
            <x-primary-button class="w-full justify-center py-2 text-xs sm:text-sm font-semibold">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>

        <div class="mt-3 text-center text-xs text-stone-500">
            ¿Aún no estás registrada?
            <a href="{{ route('register') }}" class="font-semibold text-pink-600 hover:text-pink-700 underline ms-1">
                Crear cuenta
            </a>
        </div>
    </form>
</x-guest-layout>
