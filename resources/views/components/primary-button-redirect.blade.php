@props(['href', 'external' => false, 'disabled' => false])

@php
    $classes = 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';
@endphp

@if ($disabled)
    <span {{ $attributes->merge(['class' => $classes . ' opacity-75 cursor-not-allowed']) }}>
        {{ $slot }}
    </span>
@else
    <a href="{{ $href }}"
       @if ($external) target="_blank" rel="noopener noreferrer" @endif
       {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif