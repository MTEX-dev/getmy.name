<div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
    <div>
        <button type="button" @click="open = !open"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-getmyname-500 dark:focus:ring-offset-gray-800 backdrop-blur-sm"
                id="menu-button" aria-expanded="true" aria-haspopup="true">
            {{ strtoupper(App::currentLocale()) }}
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none backdrop-blur-sm"
         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="overflow-hidden" role="none">
            @foreach (config('app.available_locales') as $code => $name)
                <a href="{{ route('change-language', ['locale' => $code]) }}"
                   class="text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm
                          {{ App::currentLocale() === $code ? 'bg-gray-100 dark:bg-gray-600 font-semibold' : 'hover:bg-gray-50 dark:hover:bg-gray-600' }}"
                   role="menuitem" tabindex="-1" id="menu-item-{{ $code }}">
                    {{ $name }}
                </a>
            @endforeach
        </div>
    </div>
</div>