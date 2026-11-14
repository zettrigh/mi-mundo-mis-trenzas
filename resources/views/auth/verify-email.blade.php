@section('title', 'Verificar Correo')

<x-guest-layout>
    <div class="mb-4 text-sm text-stone-600">
        {{ __('¡Gracias por registrarte! Antes de comenzar, confirma tu dirección de correo haciendo clic en el enlace que te enviamos. Si no lo recibiste, con gusto te enviaremos otro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-700">
            {{ __('Un nuevo enlace de verificación fue enviado a la dirección de correo que proporcionaste durante el registro.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Reenviar Enlace de Verificación') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-stone-600 hover:text-pink-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-600">
                {{ __('Cerrar Sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
