@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-white bg-[#a4161a] font-bold rounded-xl transition-all duration-200 shadow-lg shadow-red-900/20 text-base'
            : 'flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl transition-all duration-200 text-base';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
