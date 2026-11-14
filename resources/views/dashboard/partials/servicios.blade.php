<div id="catalogo-contenido">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-5">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Catálogo de Servicios de Trenzado ({{ $services->total() }})</h3>
            <p class="text-sm text-gray-500 mt-0.5">
                @if ($services->firstItem())
                    Mostrando {{ $services->firstItem() }}–{{ $services->lastItem() }} de {{ $services->total() }}.
                @else
                    Gestiona el catálogo que ve el cliente en la web.
                @endif
            </p>
        </div>
        <a href="{{ route('home') }}#servicios" class="text-xs text-pink-600 hover:underline whitespace-nowrap">Ver en la Web &rarr;</a>
    </div>

    <div class="space-y-3">
        @forelse ($services as $service)
            <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-200 shrink-0">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-gray-900 flex items-center gap-2 flex-wrap">
                            {{ $service->name }}
                            @unless ($service->is_active)
                                <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-semibold whitespace-nowrap">Inactivo</span>
                            @endunless
                        </div>
                        <div class="text-xs text-gray-500">{{ $service->category }} • {{ $service->estimated_duration_minutes }} min</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-pink-600 text-sm">${{ number_format($service->price, 2) }}</div>
                    <span class="text-[11px] text-gray-500">{{ $service->includes_extensions ? '+ Con extensiones' : 'Natural' }}</span>
                </div>
            </div>
        @empty
            <p class="py-8 text-center text-sm text-gray-500">No hay servicios que coincidan con los filtros seleccionados.</p>
        @endforelse
    </div>

    @if ($services->hasPages())
        <div class="-mx-6 -mb-6 mt-6 px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $services->links() }}
        </div>
    @endif
</div>
