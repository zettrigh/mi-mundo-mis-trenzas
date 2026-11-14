<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-stone-900 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-pink-600 focus:bg-pink-600 active:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
