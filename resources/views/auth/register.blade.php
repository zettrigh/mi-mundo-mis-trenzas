@section('title', 'Crear Cuenta')

<x-guest-layout>
    <div class="mb-3">
        <h1 class="font-serif-title text-xl sm:text-2xl font-bold text-stone-900 tracking-tight">Crear Cuenta</h1>
        <p class="text-xs text-stone-500 mt-0.5">Regístrate para agendar tus citas de trenzado a domicilio.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nombre Completo y Cédula en fila --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <div>
                <x-input-label for="name" :value="__('Nombre Completo')" class="text-xs" />
                <x-text-input id="name" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3" type="text" name="name" :value="old('name')" autofocus autocomplete="name" :pattern="'^[A-Za-zÀ-ÖØ-öø-ÿ\\s\\-\'.]+$'" title="Solo letras, espacios y guiones" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="cedula" :value="__('Cédula de Identidad')" class="text-xs" />
                <x-text-input id="cedula" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3" type="text" inputmode="numeric" name="cedula" :value="old('cedula')" placeholder="Ej: 12345678" autocomplete="off" pattern="[0-9]+" maxlength="12" title="Solo números" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                <x-input-error :messages="$errors->get('cedula')" class="mt-1" />
            </div>
        </div>

        {{-- Correo Electrónico --}}
        <div class="mt-2.5">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-xs" />
            <x-text-input id="email" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3" type="email" name="email" :value="old('email')" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Teléfono y Dirección en fila --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mt-2.5">
            <div>
                <x-input-label for="phone" :value="__('Teléfono / WhatsApp')" class="text-xs" />
                <x-text-input id="phone" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3" type="tel" inputmode="tel" name="phone" :value="old('phone')" placeholder="+58 412 0000000" autocomplete="tel" pattern="[+0-9\s\-()]+" title="Solo números y signos válidos (+, -, espacios o paréntesis)" />
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="address" :value="__('Dirección')" class="text-xs" />
                <x-text-input id="address" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3" type="text" name="address" :value="old('address')" placeholder="Av. Principal, Apto 3B" pattern="[A-Za-z0-9À-ÖØ-öø-ÿ\s\.,#\-\/º°]+" title="Letras, números y signos habituales de dirección (., #, -, /, º, °)" />
                <x-input-error :messages="$errors->get('address')" class="mt-1" />
            </div>
        </div>

        {{-- Contraseña y Confirmación en fila --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mt-2.5">
            <div>
                <x-input-label for="password" :value="__('Contraseña')" class="text-xs" />
                <x-password-input id="password" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3"
                                  name="password"
                                  autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-xs" />
                <x-password-input id="password_confirmation" class="block mt-1 w-full text-xs sm:text-sm py-1.5 px-3"
                                  name="password_confirmation" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-3.5 pt-1">
            <a class="underline text-xs text-stone-600 hover:text-pink-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-600" href="{{ route('login') }}">
                {{ __('¿Ya estás registrada?') }}
            </a>
            <x-primary-button class="ms-4 py-2 px-4 text-xs font-semibold">
                {{ __('Crear Mi Cuenta') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
