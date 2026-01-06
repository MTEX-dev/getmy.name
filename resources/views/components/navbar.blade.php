<nav x-data="{ open: false }" class="fixed w-full z-50 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('strings.dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('api-docs')" :active="request()->routeIs('api-docs')">
                        {{ __('strings.api_docs') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center space-x-4 mr-4">
                    <x-theme-toggle-single-button />
                    <x-locale-switch />
                </div>

                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 dark:text-gray-300 bg-white/10 dark:bg-gray-800/10 hover:bg-white/30 dark:hover:bg-gray-800/30 focus:outline-none transition ease-in-out duration-150 backdrop-blur-sm">
                            <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ms-2 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-0 w-52 rounded-2xl shadow-xl bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 focus:outline-none z-50">
                            
                            <div class="p-1.5 flex flex-col gap-1">
                                <div class="px-3 py-2 text-xs text-gray-400">
                                    <div class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                                    <div class="truncate text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                                
                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm transition-all duration-150 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 opacity-70">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 18V8.25m-18 0V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6ZM7.5 6h.008v.008H7.5V6Zm2.25 0h.008v.008H9.75V6Z" />
                                    </svg>
                                    {{ __('strings.dashboard') }}
                                </a>

                                <a href="{{ route('profile.get', ['username' => Auth::user()->username]) }}" class="flex items-center gap-3 px-3 py-2 text-sm transition-all duration-150 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 opacity-70">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    {{ __('profile.profile') }}
                                </a>

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm transition-all duration-150 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 opacity-70">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    {{ __('profile.settings') }}
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-between px-3 py-2 text-sm transition-all duration-150 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 group">
                                        <span>{{ __('auth.logout') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 opacity-70 group-hover:opacity-100 transition-opacity">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <x-nav-link :href="route('login')">
                        {{ __('auth.login') }}
                    </x-nav-link>
                    @if (Route::has('register'))
                        <x-nav-link :href="route('register')">
                            {{ __('auth.register') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100/90 dark:hover:bg-gray-900/90 focus:outline-none transition duration-150 ease-in-out backdrop-blur-sm">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm px-2 pb-3 pt-2">
        <div class="space-y-1">
            @include('components.nav-link-mobile', [
                'href' => route('dashboard'),
                'active' => request()->routeIs('dashboard'),
                'label' => __('strings.dashboard')
            ])
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 mt-2">
            @auth
                <div class="flex items-center px-4 mb-3">
                    <img class="h-9 w-9 rounded-full object-cover mr-2" src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}">
                    <div class="overflow-hidden">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200 truncate">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    @include('components.nav-link-mobile', [
                        'href' => route('dashboard'),
                        'label' => __('strings.dashboard')
                    ])
                    @include('components.nav-link-mobile', [
                        'href' => route('profile.get', ['username' => Auth::user()->username]),
                        'label' => __('profile.profile')
                    ])
                    @include('components.nav-link-mobile', [
                        'href' => route('profile.edit'),
                        'label' => __('profile.settings')
                    ])

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-between px-4 py-2 text-base font-medium transition-all duration-150 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 group">
                            <span>{{ __('auth.logout') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    @include('components.nav-link-mobile', [
                        'href' => route('login'),
                        'label' => __('auth.login')
                    ])
                    @if (Route::has('register'))
                        @include('components.nav-link-mobile', [
                            'href' => route('register'),
                            'label' => __('auth.register')
                        ])
                    @endif
                </div>
            @endauth

            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-600 mt-4">
                <x-theme-toggle-single-button />
                <x-locale-switch />
            </div>
        </div>
    </div>
</nav>