{{-- @props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> --}}
@props(['href', 'active' => false])

@php
$baseClasses = 'rounded-lg flex items-center py-3 px-4 transition-colors duration-200';
$activeClasses = 'bg-blue-800 text-white dark:bg-gray-700 dark:text-blue-300';
$inactiveClasses = 'text-blue-100 hover:bg-blue-700 dark:text-gray-300 dark:hover:bg-gray-700';
$classes = $active ? $baseClasses.' '.$activeClasses : $baseClasses.' '.$inactiveClasses;
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
