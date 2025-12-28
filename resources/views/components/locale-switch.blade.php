<div class="relative inline-block text-left text-gray-500" x-data="{ open: false }" @click.away="open = false">
    <div>
        <button type="button" @click="open = !open"
                class="inline-flex items-center justify-center w-full rounded-xl border shadow-sm px-4 py-2 text-sm font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-getmyname-500/50 border-gray-500 dark:text-gray-200 text-gray-800"
                :class="scrolled ? 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200' : 'bg-white/20 backdrop-blur-md border-white/30 text-white'"
                id="menu-button" aria-expanded="true" aria-haspopup="true">
            {{ strtoupper(App::currentLocale()) }}
            <svg class="ms-2 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="origin-top-right absolute right-0 mt-2 w-28 rounded-2xl shadow-xl bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 focus:outline-none z-50"
         role="menu">
        <div class="p-1.5 flex flex-col gap-1" role="none">
            @foreach (config('app.available_locales') as $code => $name)
                <a href="{{ route('change-language', ['locale' => $code]) }}"
                   class="flex items-center px-3 py-2 text-sm transition-all duration-150 rounded-xl group
                          {{ App::currentLocale() === $code 
                             ? 'bg-getmyname-50 dark:bg-getmyname-900/20 text-getmyname-700 dark:text-getmyname-400 font-bold' 
                             : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}"
                   role="menuitem">
                    <span class="flex-1">{{ $name }}</span>
                    @if (App::currentLocale() === $code)
                        <span class="flex h-2 w-2 rounded-full bg-getmyname-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>