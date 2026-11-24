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
    <body class="font-sans text-stone-800 antialiased bg-stone-50 h-full">
        <div class="min-h-screen flex flex-col lg:flex-row bg-white">
            <!-- Columna Visual / Branding (Split-Screen Izquierda) -->
            <div class="relative lg:w-5/12 xl:w-1/2 bg-gradient-to-br from-stone-950 via-rose-950 to-pink-950 text-white p-8 sm:p-12 lg:p-16 flex flex-col justify-between overflow-hidden">
                <!-- Imagen de fondo con overlay elegante -->
                <div class="absolute inset-0 bg-cover bg-center opacity-25 mix-blend-luminosity" style="background-image: url('https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?auto=format&fit=crop&w=1200&q=80');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-950/40 to-stone-950/80"></div>

                <!-- Contenido Superior: Logo e Identidad -->
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3.5 group">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Mi Mundo Mis Trenzas" class="h-14 w-14 rounded-full object-cover shadow-lg border-2 border-pink-400/80 group-hover:scale-105 transition">
                        <div>
                            <span class="font-serif-title text-2xl font-bold tracking-tight text-white block leading-tight">
                                Mi Mundo Mis Trenzas
                            </span>
                            <span class="text-xs font-semibold tracking-wider text-pink-300 uppercase block">
                                Peinados Femeninos a Domicilio
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Contenido Central: Propuesta de Valor y Características -->
                <div class="relative z-10 my-10 lg:my-auto py-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-500/20 border border-pink-400/30 text-pink-200 text-xs font-medium mb-4">
                        <i data-lucide="sparkles" class="h-3.5 w-3.5 text-pink-300"></i>
                        <span>El arte del trenzado en tu hogar</span>
                    </div>

                    <h2 class="font-serif-title text-3xl sm:text-4xl xl:text-5xl font-bold leading-tight text-white tracking-tight">
                        La belleza de tu cabello sin salir de casa.
                    </h2>

                    <p class="text-sm sm:text-base text-stone-300 mt-4 leading-relaxed max-w-lg">
                        Conectamos a estilistas profesionales y dedicadas directamente a tu puerta. Disfruta de una atención personalizada, puntual y con técnicas protectoras que cuidan tu raíz.
                    </p>

                    <!-- Lista de beneficios destacados -->
                    <div class="mt-8 space-y-3.5">
                        <div class="flex items-center gap-3 text-sm text-stone-200">
                            <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-pink-500/20 text-pink-300 border border-pink-400/30">
                                <i data-lucide="circle-check" class="h-4 w-4"></i>
                            </span>
                            <span>Knotless Braids, Box Braids, Fulani y peinados para eventos.</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-stone-200">
                            <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-pink-500/20 text-pink-300 border border-pink-400/30">
                                <i data-lucide="circle-check" class="h-4 w-4"></i>
                            </span>
                            <span>Atención a domicilio con puntualidad y bioseguridad garantizada.</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-stone-200">
                            <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-pink-500/20 text-pink-300 border border-pink-400/30">
                                <i data-lucide="circle-check" class="h-4 w-4"></i>
                            </span>
                            <span>Agenda fácil y gestión directa de tus citas desde tu panel.</span>
                        </div>
                    </div>
                </div>

                <!-- Contenido Inferior: Testimonio de Cliente -->
                <div class="relative z-10 pt-6 border-t border-white/10 hidden sm:block">
                    <div class="flex items-center gap-1 text-amber-400 mb-2">
                        <i data-lucide="star" class="h-4 w-4 fill-amber-400"></i>
                        <i data-lucide="star" class="h-4 w-4 fill-amber-400"></i>
                        <i data-lucide="star" class="h-4 w-4 fill-amber-400"></i>
                        <i data-lucide="star" class="h-4 w-4 fill-amber-400"></i>
                        <i data-lucide="star" class="h-4 w-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-300 italic">
                        "Excelente puntualidad y un trato muy delicado con el cabello. Las trenzas quedaron impecables y sin dolor."
                    </p>
                    <div class="text-[11px] font-semibold text-pink-300 mt-1 uppercase tracking-wider">
                        Valeria Morales &bull; Cliente habitual
                    </div>
                </div>
            </div>

            <!-- Columna del Formulario (Split-Screen Derecha) -->
            <div class="lg:w-7/12 xl:w-1/2 flex flex-col justify-center py-10 px-6 sm:px-12 lg:px-16 xl:px-20 bg-stone-50 overflow-y-auto">
                <div class="w-full max-w-xl mx-auto">
                    <!-- Enlace superior para regresar a inicio -->
                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-stone-500 hover:text-pink-600 transition group">
                            <svg class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Volver al inicio</span>
                        </a>

                        <span class="text-xs font-medium text-stone-400">Mi Mundo Mis Trenzas</span>
                    </div>

                    <!-- Contenedor del Formulario -->
                    <div class="bg-white p-7 sm:p-9 rounded-3xl shadow-xl shadow-stone-200/50 border border-stone-200/70">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
