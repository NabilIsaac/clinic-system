@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md group'
    : 'flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
