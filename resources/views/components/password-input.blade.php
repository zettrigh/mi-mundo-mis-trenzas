@props(['disabled' => false])

<div class="relative" x-data="{ visible: false }">
    <x-text-input
        :disabled="$disabled"
        type="password"
        x-bind:type="visible ? 'text' : 'password'"
        {{ $attributes->merge(['class' => 'pr-10']) }}
    />

    <button
        type="button"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-stone-500 hover:text-stone-700 transition-colors"
        aria-label="Mostrar contraseña"
        x-bind:aria-label="visible ? 'Ocultar contraseña' : 'Mostrar contraseña'"
        @click="visible = !visible"
        @mousedown.prevent
    >
        <span x-show="!visible">
            <i data-lucide="eye" class="h-5 w-5" aria-hidden="true"></i>
        </span>
        <span x-show="visible" style="display: none;">
            <i data-lucide="eye-off" class="h-5 w-5" aria-hidden="true"></i>
        </span>
    </button>
</div>
