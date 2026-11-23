@section('title', 'Crear Cuenta')

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" :pattern="'^[A-Za-zÀ-ÖØ-öø-ÿ\\s\\-\'.]+$'" title="Solo letras, espacios y guiones" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Cédula de Identidad -->
        <div class="mt-4">
            <x-input-label for="cedula" :value="__('Cédula de Identidad')" />
            <x-text-input id="cedula" class="block mt-1 w-full" type="text" inputmode="numeric" name="cedula" :value="old('cedula')" placeholder="Ej: 12345678" autocomplete="off" pattern="[0-9]+" maxlength="12" title="Solo números" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
            <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Teléfono / WhatsApp de Contacto')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" inputmode="tel" name="phone" :value="old('phone')" placeholder="+58 412 0000000" autocomplete="tel" pattern="[+0-9\s\-()]+" title="Solo números y signos válidos (+, -, espacios o paréntesis)" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Dirección Habitual para Citas a Domicilio')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" placeholder="Ej: Av. Principal, Edif. Aurora, Apto 3B" pattern="[A-Za-z0-9À-ÖØ-öø-ÿ\s\.,#\-\/º°]+" title="Letras, números y signos habituales de dirección (., #, -, /, º, °)" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-password-input id="password" class="block mt-1 w-full"
                              name="password"
                              autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

            <x-password-input id="password_confirmation" class="block mt-1 w-full"
                              name="password_confirmation" autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-stone-600 hover:text-pink-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-600" href="{{ route('login') }}">
                {{ __('¿Ya estás registrada?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Crear Mi Cuenta') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
