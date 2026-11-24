<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title') @yield('title') · {{ config('app.name', 'Mi Mundo Mis Trenzas') }} @else {{ config('app.name', 'Mi Mundo Mis Trenzas') }} @endif</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|playfair-display:600,700&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-800 antialiased bg-stone-50 h-full lg:overflow-hidden">
        <div class="min-h-screen lg:h-screen flex flex-col lg:flex-row bg-white lg:overflow-hidden">
            <!-- Columna Visual / Branding (Split-Screen Izquierda) — visible en lg: -->
            <div class="hidden lg:flex relative lg:w-5/12 xl:w-1/2 bg-gradient-to-br from-stone-950 via-rose-950 to-pink-950 text-white p-8 xl:p-12 flex-col justify-between overflow-hidden shrink-0">
                <!-- Imagen de fondo con overlay elegante -->
                <div class="absolute inset-0 bg-cover bg-center opacity-25 mix-blend-luminosity" style="background-image: url('https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?auto=format&fit=crop&w=1200&q=80');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-950/40 to-stone-950/80"></div>

                <!-- Contenido Superior: Logo e Identidad -->
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Mi Mundo Mis Trenzas" class="h-11 w-11 rounded-full object-cover shadow-lg border-2 border-pink-400/80 group-hover:scale-105 transition">
                        <div>
                            <span class="font-serif-title text-xl font-bold tracking-tight text-white block leading-tight">
                                Mi Mundo Mis Trenzas
                            </span>
                            <span class="text-[11px] font-semibold tracking-wider text-pink-300 uppercase block">
                                Peinados Femeninos a Domicilio
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Contenido Central: Propuesta de Valor y Características -->
                <div class="relative z-10 py-1 my-auto">
                    <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-pink-500/20 border border-pink-400/30 text-pink-200 text-xs font-medium mb-2.5">
                        <i data-lucide="sparkles" class="h-3 w-3 text-pink-300"></i>
                        <span>El arte del trenzado en tu hogar</span>
                    </div>

                    <h2 class="font-serif-title text-2xl xl:text-3xl font-bold leading-tight text-white tracking-tight">
                        La belleza de tu cabello sin salir de casa.
                    </h2>

                    <p class="text-xs sm:text-sm text-stone-300 mt-2 leading-relaxed max-w-lg">
                        Conectamos a estilistas profesionales directamente a tu puerta. Atención personalizada, puntual y con técnicas protectoras que cuidan tu raíz.
                    </p>

                    <!-- Lista de beneficios destacados -->
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center gap-2.5 text-xs sm:text-sm text-stone-200">
                            <span class="flex items-center justify-center w-6 h-6 rounded-md bg-pink-500/20 text-pink-300 border border-pink-400/30 shrink-0">
                                <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                            </span>
                            <span>Knotless Braids, Box Braids, Fulani y peinados para eventos.</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs sm:text-sm text-stone-200">
                            <span class="flex items-center justify-center w-6 h-6 rounded-md bg-pink-500/20 text-pink-300 border border-pink-400/30 shrink-0">
                                <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                            </span>
                            <span>Atención a domicilio con puntualidad y bioseguridad.</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs sm:text-sm text-stone-200">
                            <span class="flex items-center justify-center w-6 h-6 rounded-md bg-pink-500/20 text-pink-300 border border-pink-400/30 shrink-0">
                                <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                            </span>
                            <span>Agenda fácil y gestión directa de tus citas desde tu panel.</span>
                        </div>
                    </div>
                </div>

                <!-- Contenido Inferior: Testimonio de Cliente -->
                <div class="relative z-10 pt-3 border-t border-white/10">
                    <div class="flex items-center gap-1 text-amber-400 mb-1.5">
                        <i data-lucide="star" class="h-3.5 w-3.5 fill-amber-400"></i>
                        <i data-lucide="star" class="h-3.5 w-3.5 fill-amber-400"></i>
                        <i data-lucide="star" class="h-3.5 w-3.5 fill-amber-400"></i>
                        <i data-lucide="star" class="h-3.5 w-3.5 fill-amber-400"></i>
                        <i data-lucide="star" class="h-3.5 w-3.5 fill-amber-400"></i>
                    </div>
                    <p class="text-xs text-stone-300 italic leading-snug">
                        "Excelente puntualidad y un trato muy delicado con el cabello. Las trenzas quedaron impecables."
                    </p>
                    <div class="text-[11px] font-semibold text-pink-300 mt-1 uppercase tracking-wider">
                        Valeria Morales · Cliente habitual
                    </div>
                </div>
            </div>

            <!-- Columna del Formulario (Split-Screen Derecha) -->
            <div class="flex-1 flex flex-col justify-center overflow-y-auto py-4 px-4 sm:px-8 lg:px-10 xl:px-14 bg-stone-50">
                <div class="w-full max-w-lg mx-auto my-auto">
                    <!-- Branding móvil visible solo en pantallas pequeñas -->
                    <div class="lg:hidden flex items-center justify-between mb-3 pb-2 border-b border-stone-200/80">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Mi Mundo Mis Trenzas" class="h-8 w-8 rounded-full object-cover shadow border border-pink-400">
                            <span class="font-serif-title text-base font-bold tracking-tight text-stone-900">
                                Mi Mundo Mis Trenzas
                            </span>
                        </a>
                        <a href="{{ route('home') }}" class="text-[11px] font-semibold text-pink-600 hover:text-pink-700">
                            Inicio
                        </a>
                    </div>

                    <!-- Enlace superior para regresar a inicio (Desktop) -->
                    <div class="hidden lg:flex items-center justify-between mb-3">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-stone-500 hover:text-pink-600 transition group">
                            <svg class="h-3.5 w-3.5 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Volver al inicio</span>
                        </a>
                        <span class="text-xs font-medium text-stone-400">Atención a Domicilio</span>
                    </div>

                    <!-- Contenedor del Formulario -->
                    <div class="bg-white p-5 sm:p-7 rounded-2xl sm:rounded-3xl shadow-lg sm:shadow-xl shadow-stone-200/50 border border-stone-200/70">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
