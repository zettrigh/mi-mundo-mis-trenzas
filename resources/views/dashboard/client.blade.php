<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <span>💖</span> {{ __('Mi Espacio de Citas') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Hola, {{ $user->name }}. Agenda tu peinado favorito o revisa el estado de tus citas a domicilio.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-pink-100 text-pink-800 border border-pink-200">
                    Cliente Consentida
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

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
                    <div class="font-bold mb-1">Por favor verifica los siguientes campos:</div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna Izquierda: Formulario para Agendar Nueva Cita -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xl">✨</span>
                            <h3 class="font-bold text-lg text-gray-900">Agendar Cita a Domicilio</h3>
                        </div>
                        <p class="text-xs text-gray-500 mb-6">Elige el estilo que deseas y una de nuestras estilistas irá directamente a tu hogar.</p>

                        <form method="POST" action="{{ route('appointments.store') }}" class="space-y-4">
                            @csrf

                            <!-- Servicio -->
                            <div>
                                <label for="service_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Servicio / Estilo</label>
                                <select id="service_id" name="service_id" required class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                                    <option value="">Selecciona un estilo...</option>
                                    @foreach($availableServices as $srv)
                                        <option value="{{ $srv->id }}" @selected(old('service_id') == $srv->id)>
                                            {{ $srv->name }} — ${{ number_format($srv->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha y Hora -->
                            <div>
                                <label for="scheduled_at" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Fecha y Hora Deseada</label>
                                <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" required min="{{ now()->addDay()->format('Y-m-d\TH:i') }}" class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                                <span class="text-[11px] text-gray-400">Recomendamos reservar con al menos 24 horas de antelación.</span>
                            </div>

                            <!-- Teléfono de contacto -->
                            <div>
                                <label for="client_phone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Teléfono / WhatsApp</label>
                                <input type="text" id="client_phone" name="client_phone" value="{{ old('client_phone', $user->phone) }}" required placeholder="+58 412 1234567" class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <!-- Dirección -->
                            <div>
                                <label for="address" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Dirección Exacta del Domicilio</label>
                                <textarea id="address" name="address" rows="2" required placeholder="Calle, edificio/casa, piso, número de apartamento..." class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <!-- Zona / Sector -->
                            <div>
                                <label for="zone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Zona / Sector / Comuna</label>
                                <input type="text" id="zone" name="zone" value="{{ old('zone') }}" placeholder="Ej: Zona Norte, Centro, Altamira..." class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <!-- Detalles del Cabello -->
                            <div>
                                <label for="hair_details" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Detalles de tu Cabello (Opcional)</label>
                                <textarea id="hair_details" name="hair_details" rows="2" placeholder="Largo actual, textura, color o tipo de extensiones que te gustan..." class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">{{ old('hair_details') }}</textarea>
                            </div>

                            <!-- Notas adicionales -->
                            <div>
                                <label for="notes" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Indicaciones de Llegada (Opcional)</label>
                                <input type="text" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Ej: Timbre no suena, preguntar por vigilancia..." class="w-full text-sm rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-pink-600 hover:bg-pink-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                                <span>📅</span> Reservar Mi Cita a Domicilio
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Columna Derecha: Citas Activas e Historial -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Citas Activas -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Mis Citas a Domicilio Activas</h3>
                                <p class="text-xs text-gray-500">Citas en espera de confirmación, confirmadas o en camino.</p>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-pink-50 text-pink-700 rounded-full border border-pink-100">
                                {{ $activeAppointments->count() }} activas
                            </span>
                        </div>

                        @if($activeAppointments->isEmpty())
                            <div class="text-center py-10 text-gray-400">
                                <span class="text-4xl block mb-2">💆‍♀️</span>
                                <p class="text-sm font-medium text-gray-600">No tienes ninguna cita agendada actualmente.</p>
                                <p class="text-xs text-gray-400 mt-1">Usa el formulario lateral para programar tu primera sesión a domicilio.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($activeAppointments as $appointment)
                                    <div class="border border-gray-100 rounded-2xl p-5 bg-gradient-to-br from-white to-pink-50/20 shadow-sm">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-100 pb-3">
                                            <div>
                                                <span class="text-xs font-mono font-bold text-pink-600">#{{ $appointment->appointment_code }}</span>
                                                <h4 class="font-bold text-base text-gray-900">{{ $appointment->service->name }}</h4>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $appointment->status->badgeClasses() }} self-start sm:self-auto">
                                                {{ $appointment->status->label() }}
                                            </span>
                                        </div>

                                        <div class="py-3 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-700">
                                            <div>
                                                <span class="text-gray-400 block">Fecha y Hora:</span>
                                                <span class="font-bold text-gray-900">{{ $appointment->scheduled_at->translatedFormat('l, d M Y - h:i A') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-400 block">Precio Total Estimado:</span>
                                                <span class="font-bold text-pink-600 text-sm">${{ number_format($appointment->total_price, 2) }}</span>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <span class="text-gray-400 block">Dirección de Visita:</span>
                                                <span class="font-medium text-gray-900">{{ $appointment->address }} @if($appointment->zone)({{ $appointment->zone }})@endif</span>
                                            </div>

                                            <!-- Estilista asignada -->
                                            <div class="sm:col-span-2 mt-1 p-3 rounded-xl bg-white border border-gray-100 flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-full bg-pink-100 text-pink-700 flex items-center justify-center font-bold text-sm">
                                                        {{ $appointment->stylist ? substr($appointment->stylist->name, 0, 1) : '?' }}
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-900">
                                                            {{ $appointment->stylist ? $appointment->stylist->name : 'Asignando estilista...' }}
                                                        </div>
                                                        <div class="text-[11px] text-gray-500">
                                                            {{ $appointment->stylist ? 'Estilista a Domicilio Asignada' : 'Te notificaremos en cuanto sea asignada' }}
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($appointment->stylist && $appointment->stylist->phone)
                                                    @php $phoneClean = preg_replace('/[^0-9]/', '', $appointment->stylist->phone); @endphp
                                                    <a href="https://wa.me/{{ $phoneClean }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-semibold transition">
                                                        WhatsApp Estilista
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        @if($appointment->status === \App\Enums\AppointmentStatus::Pending)
                                            <div class="pt-3 border-t border-gray-100 flex justify-end">
                                                <form method="POST" action="{{ route('appointments.cancel', $appointment) }}" onsubmit="return confirm('¿Segura que deseas cancelar esta cita?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">
                                                        Cancelar solicitud de cita
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Historial de Peinados Realizados -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">Historial de Peinados Realizados</h3>
                        <p class="text-xs text-gray-500 mb-4">Citas completadas y calificaciones dejadas a nuestras trenzadoras.</p>

                        <div class="divide-y divide-gray-100">
                            @forelse($historyAppointments as $past)
                                <div class="py-4 space-y-2">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                        <div class="font-semibold text-sm text-gray-900">
                                            {{ $past->service->name }} • <span class="font-mono text-xs text-gray-500">#{{ $past->appointment_code }}</span>
                                        </div>
                                        <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold border {{ $past->status->badgeClasses() }} self-start sm:self-auto">
                                            {{ $past->status->label() }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Fecha: {{ $past->scheduled_at->translatedFormat('d M Y') }} • Estilista: {{ $past->stylist?->name ?? 'Estilista certificada' }}
                                    </div>

                                    @if($past->status === \App\Enums\AppointmentStatus::Completed)
                                        @if($past->review)
                                            <div class="mt-2 text-xs p-2.5 bg-amber-50 rounded-xl border border-amber-200 text-amber-900">
                                                <span class="font-bold">Tu Calificación:</span> {{ str_repeat('⭐', $past->review->rating) }}
                                                @if($past->review->comment)
                                                    <p class="italic mt-0.5">"{{ $past->review->comment }}"</p>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Formulario para dejar calificación -->
                                            <form method="POST" action="{{ route('appointments.reviews.store', $past) }}" class="mt-2 p-3 bg-gray-50 rounded-xl border border-gray-200 flex flex-col sm:flex-row sm:items-center gap-2 text-xs">
                                                @csrf
                                                <span class="font-semibold text-gray-700">Califica el servicio:</span>
                                                <select name="rating" required class="text-xs rounded-lg border-gray-300 py-1">
                                                    <option value="5">⭐⭐⭐⭐⭐ (Excelente)</option>
                                                    <option value="4">⭐⭐⭐⭐ (Muy Bueno)</option>
                                                    <option value="3">⭐⭐⭐ (Bueno)</option>
                                                    <option value="2">⭐⭐ (Regular)</option>
                                                    <option value="1">⭐ (Malo)</option>
                                                </select>
                                                <input type="text" name="comment" placeholder="Comentario sobre el peinado y puntualidad..." class="text-xs rounded-lg border-gray-300 flex-1 py-1">
                                                <button type="submit" class="px-3 py-1 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-lg">
                                                    Enviar Reseña
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 py-4 text-center">Aún no cuentas con historial de peinados anteriores.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

