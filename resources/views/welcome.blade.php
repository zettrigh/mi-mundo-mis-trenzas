<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Mundo Mis Trenzas | Peinados Femeninos y Trenzas a Domicilio</title>
    <meta name="description" content="Trenzas y peinados femeninos a domicilio: estilistas profesionales llegan a tu casa con técnicas sin dolor, materiales premium y precios claros. Agenda tu cita en línea.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|playfair-display:600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800 antialiased selection:bg-pink-500 selection:text-white">

    <!-- Barra de Navegación Superior -->
    <header x-data="{ open: false }" class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-rose-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logotipo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Mi Mundo Mis Trenzas" class="h-12 w-12 sm:h-14 sm:w-14 rounded-full object-cover shadow-md border-2 border-pink-300 group-hover:scale-105 transition">
                    <div>
                        <span class="font-serif-title text-xl font-bold tracking-tight text-stone-900 group-hover:text-pink-600 transition block leading-tight">
                            Mi Mundo Mis Trenzas
                        </span>
                        <span class="text-[11px] font-semibold tracking-wider text-rose-500 uppercase block">
                            Peinados Femeninos a Domicilio
                        </span>
                    </div>
                </a>

                <!-- Enlaces del Menú -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-stone-600">
                    <a href="#servicios" class="hover:text-pink-600 transition">Catálogo de Peinados</a>
                    <a href="#beneficios" class="hover:text-pink-600 transition">Por Qué a Domicilio</a>
                    <a href="#como-funciona" class="hover:text-pink-600 transition">Cómo Funciona</a>
                </nav>

                <!-- Acciones / Autenticación -->
                <div class="flex items-center gap-3">
                    <!-- Botón de menú móvil -->
                    <button @click="open = ! open" :aria-expanded="open" aria-controls="menu-movil" aria-label="Abrir menú de navegación" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl text-stone-600 hover:text-pink-600 hover:bg-stone-100 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-pink-600 hover:bg-pink-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition">
                                <span>Mi Panel</span>
                                <span class="text-xs bg-pink-800/40 px-2 py-0.5 rounded-md">{{ Auth::user()->role->label() }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-stone-700 hover:text-pink-600 font-medium text-sm transition">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-1 px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition">
                                <span>Registrarme</span>
                                <i data-lucide="heart" class="h-3.5 w-3.5"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
        <div id="menu-movil" @click.outside="open = false" :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-rose-100 bg-white/95 backdrop-blur-md">
            <div class="px-4 py-3 space-y-1">
                <a href="#servicios" @click="open = false" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 hover:bg-stone-100 hover:text-pink-700 transition">Catálogo de Peinados</a>
                <a href="#beneficios" @click="open = false" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 hover:bg-stone-100 hover:text-pink-700 transition">Por Qué a Domicilio</a>
                <a href="#como-funciona" @click="open = false" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 hover:bg-stone-100 hover:text-pink-700 transition">Cómo Funciona</a>
                @auth
                    <a href="{{ route('dashboard') }}" @click="open = false" class="block px-3 py-2.5 mt-2 rounded-xl text-sm font-semibold text-white bg-pink-600 hover:bg-pink-700 transition text-center">Ir a Mi Panel</a>
                @else
                    <a href="{{ route('register') }}" @click="open = false" class="block px-3 py-2.5 mt-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 transition text-center">Registrarme</a>
                    <a href="{{ route('login') }}" @click="open = false" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 hover:bg-stone-100 hover:text-pink-700 transition text-center">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <!-- Sección Hero -->
        <section class="relative overflow-hidden pt-12 pb-20 lg:py-28 bg-gradient-to-b from-rose-50/60 via-stone-50 to-stone-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Texto Principal -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-100/80 border border-pink-200 text-pink-800 text-xs font-bold uppercase tracking-wider">
                            <i data-lucide="sparkles" class="h-3.5 w-3.5"></i> Servicio Profesional a la Puerta de tu Hogar
                        </div>

                        <h1 class="font-serif-title text-4xl sm:text-5xl lg:text-6xl font-extrabold text-stone-900 leading-tight">
                            El arte del trenzado femenino en la <span class="text-pink-600">comodidad de tu casa</span>
                        </h1>

                        <p class="text-lg text-stone-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                            Olvídate del tráfico y de largas horas de espera en el salón. Nuestras estilistas profesionales van directamente a tu domicilio con materiales de primera, técnicas sin dolor y peinados duraderos.
                        </p>

                        <!-- Botones de Acción -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                            @auth
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-bold text-base shadow-xl shadow-pink-500/20 hover:scale-105 transition flex items-center justify-center gap-2">
                                    <i data-lucide="calendar" class="h-5 w-5"></i> Agendar Cita en Mi Panel
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-bold text-base shadow-xl shadow-pink-500/20 hover:scale-105 transition flex items-center justify-center gap-2">
                                    <i data-lucide="heart" class="h-5 w-5"></i> Agendar Cita a Domicilio
                                </a>
                            @endauth

                            <a href="#servicios" class="w-full sm:w-auto px-7 py-4 rounded-2xl bg-white hover:bg-stone-100 text-stone-800 font-bold text-base border border-stone-200 shadow-sm transition flex items-center justify-center gap-2">
                                Ver Catálogo y Precios &darr;
                            </a>
                        </div>

                        <!-- Garantías Rápidas -->
                        <div class="grid grid-cols-3 gap-4 pt-6 border-t border-rose-100/80 text-left">
                            <div>
                                <span class="font-bold text-xl text-stone-900 block font-serif-title">100%</span>
                                <span class="text-xs text-stone-600">A tu Domicilio</span>
                            </div>
                            <div>
                                <span class="font-bold text-xl text-stone-900 block font-serif-title">Cero Dolor</span>
                                <span class="text-xs text-stone-600">Cuidado capilar</span>
                            </div>
                            <div>
                                <span class="font-bold text-xl text-stone-900 block font-serif-title"><i data-lucide="star" class="h-4 w-4 fill-amber-400 text-amber-400 inline-block align-[-2px]"></i> 4.9/5</span>
                                <span class="text-xs text-stone-600">Satisfacción total</span>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen Destacada -->
                    <div class="lg:col-span-5 relative">
                        <div class="relative mx-auto max-w-md lg:max-w-none">
                            <!-- Decoración de Fondo -->
                            <div class="absolute -top-6 -left-6 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                            <div class="absolute -bottom-6 -right-6 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

                            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                                <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?auto=format&fit=crop&w=900&q=80" alt="Trenzas Knotless a domicilio" class="w-full h-[460px] object-cover" decoding="async">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-6">
                                    <div class="bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-white/40 shadow-lg text-stone-900 w-full">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold">
                                                <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-sm">Servicio VIP a Domicilio</div>
                                                <div class="text-xs text-stone-500">Estilistas con bioseguridad y todos los implementos</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Beneficios del Servicio a Domicilio -->
        <section id="beneficios" class="scroll-mt-24 py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                    <span class="text-xs font-bold text-rose-600 uppercase tracking-widest">¿Por qué elegirnos?</span>
                    <h2 class="font-serif-title text-3xl sm:text-4xl font-bold text-stone-900">
                        La experiencia de belleza que mereces, en tu propio espacio
                    </h2>
                    <p class="text-stone-600 text-sm sm:text-base">
                        Hacerse trenzas lleva tiempo; disfrutarlo en tu sillón favorito con tu música y sin prisas lo cambia todo.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Tarjeta 1 -->
                    <div class="p-8 rounded-3xl bg-stone-50 border border-stone-200/80 hover:border-pink-200 hover:shadow-xl transition group">
                        <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m3 9.5 9-7 9 7" />
                                <path d="M5 8.5V21h14V8.5" />
                                <path d="M9 21v-6h6v6" />
                            </svg>
                        </div>
                        <h3 class="font-serif-title text-xl font-bold text-stone-900 mb-2">Comodidad y Privacidad Total</h3>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            No gastes en transporte ni pases horas sentada en salones ruidosos. Atendemos en la tranquilidad de tu sala o habitación.
                        </p>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div class="p-8 rounded-3xl bg-stone-50 border border-stone-200/80 hover:border-pink-200 hover:shadow-xl transition group">
                        <div class="w-14 h-14 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 3l7 2.5V11c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V5.5z" />
                                <path d="m9 11.5 2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="font-serif-title text-xl font-bold text-stone-900 mb-2">Técnicas Sin Tracción Excesiva</h3>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            Priorizamos la salud de tus folículos pilosos y bordes (edges). Especialistas en trenzas Knotless y peinados protectores indoloros.
                        </p>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div class="p-8 rounded-3xl bg-stone-50 border border-stone-200/80 hover:border-pink-200 hover:shadow-xl transition group">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6 3h12l4 6-10 13L2 9z" />
                                <path d="M11 3 8 9l4 13 4-13-3-6" />
                                <path d="M2 9h20" />
                            </svg>
                        </div>
                        <h3 class="font-serif-title text-xl font-bold text-stone-900 mb-2">Materiales y Sellado Premium</h3>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            Fibras livianas Kanekalon, aceites nutritivos, gomitas que no parten el cabello y sellado en agua caliente para puntas perfectas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Catálogo de Servicios y Peinados -->
        <section id="servicios" class="scroll-mt-24 py-20 bg-stone-100/70 border-t border-b border-stone-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                    <span class="text-xs font-bold text-pink-700 uppercase tracking-widest">Estilos y Tendencias</span>
                    <h2 class="font-serif-title text-3xl sm:text-4xl font-bold text-stone-900">
                        Catálogo de Peinados Femeninos
                    </h2>
                    <p class="text-stone-600 text-sm sm:text-base">
                        Precios transparentes y tiempos estimados. Agenda el estilo que mejor resalte tu belleza.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($services as $service)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition border border-stone-200/70 flex flex-col">
                            <!-- Imagen del Peinado -->
                            <div class="h-56 overflow-hidden relative group">
                                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy" decoding="async">
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/95 text-stone-900 shadow-sm backdrop-blur-sm">
                                        {{ $service->category }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-stone-900/80 text-white shadow-sm backdrop-blur-sm inline-flex items-center gap-1">
                                        <i data-lucide="clock" class="h-3.5 w-3.5"></i> {{ $service->estimated_duration_minutes }} min
                                    </span>
                                </div>
                            </div>

                            <!-- Contenido -->
                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-baseline justify-between mb-2">
                                        <h3 class="font-serif-title font-bold text-lg text-stone-900">{{ $service->name }}</h3>
                                    </div>
                                    <p class="text-xs text-stone-600 line-clamp-3 leading-relaxed">
                                        {{ $service->description }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-xs text-stone-500 block font-medium">Tarifa del Servicio:</span>
                                        <span class="font-serif-title text-2xl font-bold text-pink-600">${{ number_format($service->price, 2) }}</span>
                                    </div>

                                    @auth
                                        <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded-xl bg-stone-900 hover:bg-pink-600 text-white text-sm font-bold transition shadow-sm">
                                            Agendar Cita &rarr;
                                        </a>
                                    @else
                                        <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-stone-900 hover:bg-pink-600 text-white text-sm font-bold transition shadow-sm">
                                            Agendar Cita &rarr;
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16 text-stone-600">
                            No hay servicios activos disponibles en este momento.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Cómo Funciona el Servicio a Domicilio -->
        <section id="como-funciona" class="scroll-mt-24 py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                    <span class="text-xs font-bold text-rose-600 uppercase tracking-widest">Fácil y Rápido</span>
                    <h2 class="font-serif-title text-3xl sm:text-4xl font-bold text-stone-900">
                        ¿Cómo Funciona la Cita en tu Hogar?
                    </h2>
                    <p class="text-stone-600 text-sm sm:text-base">
                        Solo tres sencillos pasos para lucir tus trenzas soñadas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <!-- Paso 1 -->
                    <div class="text-center p-6 space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-pink-50 border-2 border-pink-200 text-pink-600 font-serif-title text-2xl font-bold flex items-center justify-center mx-auto shadow-sm">
                            1
                        </div>
                        <h3 class="font-serif-title font-bold text-xl text-stone-900">Elige Estilo y Fecha</h3>
                        <p class="text-sm text-stone-600">
                            Regístrate en la plataforma, selecciona tu peinado predilecto y la fecha/hora en que deseas recibir a la trenzadora.
                        </p>
                    </div>

                    <!-- Paso 2 -->
                    <div class="text-center p-6 space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-rose-50 border-2 border-rose-200 text-rose-600 font-serif-title text-2xl font-bold flex items-center justify-center mx-auto shadow-sm">
                            2
                        </div>
                        <h3 class="font-serif-title font-bold text-xl text-stone-900">Visita a tu Domicilio</h3>
                        <p class="text-sm text-stone-600">
                            Te asignamos una estilista certificada que llegará puntualmente a tu dirección con los productos y herramientas necesarias.
                        </p>
                    </div>

                    <!-- Paso 3 -->
                    <div class="text-center p-6 space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-amber-50 border-2 border-amber-200 text-amber-700 font-serif-title text-2xl font-bold flex items-center justify-center mx-auto shadow-sm">
                            3
                        </div>
                        <h3 class="font-serif-title font-bold text-xl text-stone-900">¡Luce tus Trenzas!</h3>
                        <p class="text-sm text-stone-600">
                            Disfruta de un acabado impecable, ligero y profesional que protegerá tu cabello natural durante semanas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Banner de Llamada a la Acción -->
        <section class="py-16 bg-stone-900 text-white relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
                <h2 class="font-serif-title text-3xl sm:text-5xl font-bold leading-tight">
                    ¿Lista para estrenar tu nuevo peinado a domicilio?
                </h2>
                <p class="text-stone-300 text-base max-w-2xl mx-auto">
                    Reserva tu cita hoy mismo. Nuestro equipo de estilistas está listo para consentirte en casa.
                </p>
                <div class="pt-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-bold text-base shadow-xl transition transform hover:scale-105">
                            <i data-lucide="calendar" class="h-5 w-5"></i> Ir a mi Panel de Citas
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-bold text-base shadow-xl transition transform hover:scale-105">
                            <i data-lucide="sparkles" class="h-5 w-5"></i> Crear Mi Cuenta y Agendar
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <!-- Pie de Página -->
    <footer class="bg-stone-950 text-stone-400 py-12 text-sm border-t border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Mi Mundo Mis Trenzas" class="w-12 h-12 rounded-full object-cover border border-stone-700">
                    <div>
                        <span class="font-serif-title text-xl font-bold text-white block">Mi Mundo Mis Trenzas</span>
                        <span class="text-xs text-stone-400">Gestor de Citas y Peinados Femeninos a Domicilio</span>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-6 text-xs text-stone-400">
                    <a href="#servicios" class="hover:text-pink-400 transition">Catálogo</a>
                    <a href="#beneficios" class="hover:text-pink-400 transition">Beneficios</a>
                    <a href="{{ route('login') }}" class="hover:text-pink-400 transition">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="hover:text-pink-400 transition">Registro de Clientes</a>
                </div>
                <div class="text-xs text-stone-400">
                    &copy; {{ date('Y') }} Mi Mundo Mis Trenzas. Todos los derechos reservados.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
