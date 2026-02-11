@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 bg-gray-50/50 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm transition-all duration-200 px-4 py-2.5']) }}>
