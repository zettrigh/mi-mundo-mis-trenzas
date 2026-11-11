<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-stone-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 bg-stone-50">
            <div class="text-center">
                <a href="/" class="flex flex-col items-center gap-2 group">
                    <x-application-logo class="w-24 h-24 ring-4 ring-pink-100 group-hover:scale-105 transition" />
                    <span class="font-serif text-2xl font-bold tracking-tight text-stone-900 mt-2 block">
                        Mi Mundo Mis Trenzas
                    </span>
                    <span class="text-xs font-semibold tracking-wider text-rose-500 uppercase block">
                        Peinados Femeninos a Domicilio
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-xl shadow-stone-200/50 border border-stone-200/80 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
