@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-stone-300 focus:border-pink-600 focus:ring-pink-600 rounded-xl shadow-sm']) }}>
