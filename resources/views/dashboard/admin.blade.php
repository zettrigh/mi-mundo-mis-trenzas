<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <i data-lucide="crown" class="h-6 w-6"></i> {{ __('Panel Administrativo') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Gestión general de citas a domicilio, estilistas y servicios de Mi Mundo Mis Trenzas.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-sm">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Métricas Clave -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <!-- 1. Citas Totales -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Citas Totales</div>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-3xl font-extrabold text-gray-900">{{ $metrics['total_appointments'] }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">Histórico</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Pendientes -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-amber-200 bg-amber-50/30 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-medium text-amber-700 uppercase tracking-wider">Pendientes</div>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-3xl font-extrabold text-amber-600">{{ $metrics['pending_appointments'] }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">Por Atender</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Canceladas -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-rose-200 bg-rose-50/30 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-medium text-rose-700 uppercase tracking-wider">Canceladas</div>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-3xl font-extrabold text-rose-600">{{ $metrics['cancelled_appointments'] }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-rose-100 text-rose-800">Canceladas</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Ganancias (Semanal en USD y Bs.) -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-200 bg-emerald-50/30 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-xs font-medium text-emerald-800 uppercase tracking-wider">Ganancias</span>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Semana</span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-1.5 flex-wrap">
                            <span class="text-2xl sm:text-3xl font-extrabold text-gray-900">${{ number_format($metrics['weekly_revenue_usd'], 2) }}</span>
                            <span class="text-xs font-semibold text-gray-500">USD</span>
                        </div>
                        <div class="text-xs font-semibold text-emerald-700 mt-1">
                            ≈ Bs. {{ number_format($metrics['weekly_revenue_ves'], 2, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-[11px] text-gray-400 mt-2.5 pt-2 border-t border-emerald-100 flex items-center justify-between">
                        <span>Resetea lunes 00:00</span>
                        <span>Tasa: {{ number_format($metrics['exchange_rate_ves'], 2, ',', '.') }} Bs/$</span>
                    </div>
                </div>
            </div>

            <!-- Tabla de Control de Citas -->
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Todas las Citas a Domicilio</h3>
                        <p class="text-sm text-gray-500">Asigna estilistas y actualiza el estado operativo de cada cita.</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ $appointments->total() }} registros encontrados</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-100">
                            <tr>
                                <th class="py-4 px-6">Código / Fecha</th>
                                <th class="py-4 px-6">Cliente</th>
                                <th class="py-4 px-6">Servicio</th>
                                <th class="py-4 px-6">Dirección / Zona</th>
                                <th class="py-4 px-6">Estilista Asignada</th>
                                <th class="py-4 px-6">Estado</th>
                                <th class="py-4 px-6 text-right">Actualizar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($appointments as $appointment)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        <div class="font-mono text-xs font-bold text-pink-600">{{ $appointment->appointment_code }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $appointment->scheduled_at->translatedFormat('d M Y, h:i A') }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900">{{ $appointment->client->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->client_phone }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900">{{ $appointment->service->name }}</div>
                                        <div class="text-xs text-gray-500">${{ number_format($appointment->total_price, 2) }} • {{ $appointment->service->estimated_duration_minutes }} min</div>
                                    </td>
                                    <td class="py-4 px-6 max-w-xs">
                                        <div class="text-xs text-gray-800 truncate" title="{{ $appointment->address }}">{{ $appointment->address }}</div>
                                        @if($appointment->zone)
                                            <span class="inline-flex items-center gap-1 mt-0.5 text-[11px] font-medium text-gray-500"><i data-lucide="map-pin" class="h-3 w-3"></i> {{ $appointment->zone }}</span>
                                        @endif
                                    </td>

                                    <!-- Formulario en línea para Asignación y Estado -->
                                    <td colspan="3" class="py-4 px-6">
                                        <form method="POST" action="{{ route('appointments.updateByAdmin', $appointment) }}" class="flex items-center gap-3 justify-end">
                                            @csrf
                                            @method('PATCH')

                                            <!-- Selector de Estilista -->
                                            <select name="stylist_id" class="text-xs rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500 py-1.5 px-2.5">
                                                <option value="">-- Sin Asignar --</option>
                                                @foreach ($stylists as $stylist)
                                                    <option value="{{ $stylist->id }}" @selected($appointment->stylist_id == $stylist->id)>
                                                        {{ $stylist->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!-- Selector de Estado -->
                                            <select name="status" class="text-xs rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500 py-1.5 px-2.5">
                                                @foreach (\App\Enums\AppointmentStatus::cases() as $statusCase)
                                                    <option value="{{ $statusCase->value }}" @selected($appointment->status === $statusCase)>
                                                        {{ $statusCase->label() }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="submit" class="px-3 py-1.5 bg-gray-900 hover:bg-black text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                                Guardar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-400">
                                        No hay citas registradas en el sistema aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($appointments->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>

            <!-- Equipo de Estilistas y Resumen de Servicios -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Estilistas -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-between">
                        <span>Estilistas a Domicilio ({{ $stylists->count() }})</span>
                        <span class="text-xs text-pink-600 font-normal">Disponibles para asignar</span>
                    </h3>
                    <div class="space-y-4">
                        @forelse($stylists as $stylist)
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 flex items-start justify-between gap-4">
                                <div>
                                    <div class="font-bold text-gray-900">{{ $stylist->name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5 inline-flex items-center gap-1"><i data-lucide="phone" class="h-3.5 w-3.5"></i> {{ $stylist->phone ?? 'Sin teléfono registrado' }} • {{ $stylist->email }}</div>
                                    <p class="text-xs text-gray-600 mt-2">{{ $stylist->bio ?? 'Trenzadora profesional especializada en servicio a domicilio.' }}</p>
                                </div>
                                <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-semibold whitespace-nowrap">
                                    Activa
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No hay estilistas registradas.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Catálogo de Servicios -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="catalogoServicios">
                    <form method="GET" action="{{ route('dashboard') }}" x-ref="filtros" @change="aplicar()" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
                        <div>
                            <label for="servicios_orden" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Ordenar por</label>
                            <select id="servicios_orden" name="orden" class="w-full text-xs rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500 py-1.5 px-2.5">
                                <option value="reciente" @selected($serviceOrden === 'reciente')>Más reciente</option>
                                <option value="nombre" @selected($serviceOrden === 'nombre')>Nombre</option>
                                <option value="precio" @selected($serviceOrden === 'precio')>Precio</option>
                            </select>
                        </div>
                        <div>
                            <label for="servicios_direccion" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Dirección</label>
                            <select id="servicios_direccion" name="direccion" class="w-full text-xs rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500 py-1.5 px-2.5">
                                <option value="asc" @selected($serviceDireccion === 'asc')>Ascendente</option>
                                <option value="desc" @selected($serviceDireccion === 'desc')>Descendente</option>
                            </select>
                        </div>
                        <div>
                            <label for="servicios_estado" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Estado</label>
                            <select id="servicios_estado" name="estado" class="w-full text-xs rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500 py-1.5 px-2.5">
                                <option value="todos" @selected($serviceEstado === 'todos')>Todos</option>
                                <option value="activos" @selected($serviceEstado === 'activos')>Activos</option>
                                <option value="inactivos" @selected($serviceEstado === 'inactivos')>Inactivos</option>
                            </select>
                        </div>
                        <noscript>
                            <div class="sm:col-span-3">
                                <button type="submit" class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Aplicar filtros</button>
                            </div>
                        </noscript>
                    </form>

                    <div
                        x-ref="contenido"
                        :class="cargando ? 'opacity-50 pointer-events-none' : ''"
                        :aria-busy="cargando"
                        @click="alHacerClick($event)"
                        class="transition-opacity duration-150"
                    >
                        @include('dashboard.partials.servicios')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

