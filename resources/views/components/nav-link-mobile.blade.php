@props(['active' => false, 'href', 'label'])

<a href="{{ $href }}" class="flex items-center px-4 py-2 text-base font-medium transition-all duration-150 rounded-xl {{ $active ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'  : 'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
    {{ $label }}
</a>