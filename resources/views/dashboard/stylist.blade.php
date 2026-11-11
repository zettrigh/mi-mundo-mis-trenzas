<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <span>✨</span> {{ __('Panel de Estilista a Domicilio') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Bienvenida, {{ $user->name }}. Aquí tienes tu itinerario de visitas y citas asignadas.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">
                    Estilista / Trenzadora Profesional
                </span>
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

            <!-- Resumen de Métricas de la Estilista -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Citas Hoy</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-3xl font-extrabold text-gray-900">{{ $metrics['today_count'] }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-pink-100 text-pink-800">Itinerario</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Próximas Visitas</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-3xl font-extrabold text-purple-600">{{ $metrics['upcoming_count'] }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-purple-100 text-purple-800">Programadas</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Servicios Realizados</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-3xl font-extrabold text-emerald-600">{{ $metrics['completed_count'] }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Completados</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Calificación Promedio</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-3xl font-extrabold text-amber-500">⭐ {{ $metrics['average_rating'] }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">{{ $metrics['reviews_count'] }} reseñas</span>
                    </div>
                </div>
            </div>

            <!-- Citas Asignadas / Próximas Visitas -->
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="border-b border-gray-100 pb-4 mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Agenda de Citas a Domicilio Asignadas</h3>
                        <p class="text-sm text-gray-500">Detalles de dirección, requerimientos de cabello y contacto de cada cliente.</p>
                    </div>
                    <span class="text-xs font-medium px-3 py-1 bg-pink-50 text-pink-700 rounded-lg border border-pink-100">
                        {{ $upcomingAppointments->count() }} activas
                    </span>
                </div>

                @if($upcomingAppointments->isEmpty())
                    <div class="py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="font-medium text-gray-600">No tienes citas pendientes asignadas en este momento.</p>
                        <p class="text-xs text-gray-400 mt-1">La administradora te notificará cuando se te asigne una nueva cliente.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-3 border-b border-gray-100 pb-3">
                                    <div>
                                        <span class="text-xs font-mono font-bold text-pink-600">#{{ $appointment->appointment_code }}</span>
                                        <h4 class="font-bold text-base text-gray-900 mt-0.5">{{ $appointment->service->name }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">⏱ Duración estimada: {{ $appointment->service->estimated_duration_minutes }} min</p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $appointment->status->badgeClasses() }}">
                                        {{ $appointment->status->label() }}
                                    </span>
                                </div>

                                <div class="py-3 space-y-2 text-sm text-gray-700">
                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="text-gray-400">📅 Fecha y Hora:</span>
                                        <span class="font-semibold text-gray-900">{{ $appointment->scheduled_at->translatedFormat('l, d F Y - h:i A') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="text-gray-400">👤 Cliente:</span>
                                        <span class="font-semibold text-gray-900">{{ $appointment->client->name }}</span>
                                    </div>

                                    <div class="flex items-start gap-2 text-xs">
                                        <span class="text-gray-400 shrink-0">📍 Dirección:</span>
                                        <div class="font-medium text-gray-900">
                                            {{ $appointment->address }}
                                            @if($appointment->zone)
                                                <span class="text-gray-500">({{ $appointment->zone }})</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($appointment->hair_details)
                                        <div class="p-2.5 rounded-lg bg-pink-50/50 border border-pink-100 text-xs text-pink-900">
                                            <span class="font-semibold">Detalles de cabello:</span> {{ $appointment->hair_details }}
                                        </div>
                                    @endif

                                    @if($appointment->notes)
                                        <div class="p-2.5 rounded-lg bg-gray-50 text-xs text-gray-600">
                                            <span class="font-semibold">Indicaciones de llegada:</span> {{ $appointment->notes }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Acciones y Enlaces de Utilidad -->
                                <div class="pt-3 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $appointment->client_phone);
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-semibold transition">
                                            <span>💬 WhatsApp</span>
                                        </a>

                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($appointment->address . ' ' . $appointment->zone) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 text-xs font-semibold transition">
                                            <span>🗺 Ver Mapa</span>
                                        </a>
                                    </div>

                                    <form method="POST" action="{{ route('appointments.updateStatusByStylist', $appointment) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        @if($appointment->status === \App\Enums\AppointmentStatus::Confirmed)
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                                                🚗 En Camino / Iniciar
                                            </button>
                                        @elseif($appointment->status === \App\Enums\AppointmentStatus::InProgress)
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                                                ✅ Marcar Completado
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Historial de Servicios Completados y Reseñas -->
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Últimos Servicios Completados por Ti</h3>
                <div class="divide-y divide-gray-100">
                    @forelse($completedAppointments as $completed)
                        <div class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <div class="font-bold text-gray-900 text-sm">{{ $completed->service->name }} • #{{ $completed->appointment_code }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    Cliente: {{ $completed->client->name }} • {{ $completed->scheduled_at->translatedFormat('d M Y') }}
                                </div>
                                @if($completed->review)
                                    <div class="mt-2 text-xs bg-amber-50 border border-amber-200 p-2.5 rounded-lg text-amber-900">
                                        <div class="font-semibold text-amber-700">Calificación del cliente: {{ str_repeat('⭐', $completed->review->rating) }}</div>
                                        @if($completed->review->comment)
                                            <p class="mt-1 italic">"{{ $completed->review->comment }}"</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-semibold self-start sm:self-auto">
                                Completada
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-4 text-center">Aún no tienes servicios completados registrados.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

