<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MTEX.dev') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
    </style>
</head>
<body 
    class="font-sans antialiased flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 selection:bg-getmyname-500 selection:text-white" 
    x-data="{ sidebarExpanded: localStorage.getItem('sidebarExpanded') === 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebarExpanded', value))"
>
    @include('components.navbar')
    @include('components.toast-messages')

    <!-- Ambient Background -->
    <div class="fixed top-0 left-0 w-full h-96 bg-gradient-to-b from-getmyname-50/50 to-transparent dark:from-getmyname-900/10 dark:to-transparent -z-10 pointer-events-none"></div>

    <!-- Main Flex Container (Sidebar + Content) -->
    <div class="flex-1 flex pt-16 relative">
        
        <!-- Sidebar -->
        <aside 
            class="flex-shrink-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-r border-gray-200 dark:border-gray-700 z-40 transition-all duration-300 ease-in-out flex flex-col sticky top-16 h-[calc(100vh-4rem)]"
            :class="sidebarExpanded ? 'w-64' : 'w-20'"
        >
            <!-- Header Toggle -->
            <div class="h-16 flex-shrink-0 flex items-center justify-between px-4 border-b border-gray-100 dark:border-gray-700/50">
                <span 
                    class="font-bold text-lg text-gray-800 dark:text-gray-100 whitespace-nowrap overflow-hidden transition-all duration-300"
                    :class="sidebarExpanded ? 'opacity-100 w-auto' : 'opacity-0 w-0'"
                >
                    {{ __('Navigation') }}
                </span>
                <button 
                    @click="sidebarExpanded = !sidebarExpanded" 
                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-getmyname-500/50"
                >
                    <svg class="w-6 h-6 transition-transform duration-300" :class="!sidebarExpanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
                </button>
            </div>

            <!-- Nav Items -->
            <nav 
                class="flex-1 p-3 space-y-1 group/sidebar"
                :class="sidebarExpanded ? 'overflow-y-auto overflow-x-hidden no-scrollbar' : 'overflow-visible'"
            >
                @php
                    $menuItems = [
                        ['route' => 'profile.edit', 'label' => __('profile.profile'), 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['route' => 'profile.about-me', 'label' => __('profile.about_me_title'), 'icon' => 'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['route' => 'profile.avatar', 'label' => __('profile.avatar'), 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['route' => 'profile.socials', 'label' => __('profile.socials.title'), 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                        ['route' => 'profile.skills', 'label' => __('profile.skills'), 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                        ['route' => 'profile.design', 'label' => __('profile.design'), 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
                        ['route' => 'profile.education', 'match' => 'profile.education*', 'label' => __('profile.education'), 'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                        ['route' => 'profile.experiences', 'match' => 'profile.experiences*', 'label' => __('profile.experiences.title'), 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['route' => 'profile.projects', 'match' => 'profile.projects*', 'label' => __('profile.projects.title'), 'icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z'],
                        ['route' => 'profile.api-tokens.index', 'label' => __('profile.api_tokens'), 'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
                        ['route' => 'profile.api-requests.index', 'label' => __('profile.api_requests'), 'icon' => 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['route' => 'profile.activity', 'label' => __('profile.activity'), 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['route' => 'profile.password', 'label' => __('profile.password'), 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    @php
                        $isActive = isset($item['match']) ? request()->routeIs($item['match']) : request()->routeIs($item['route']);
                    @endphp
                    <a 
                        href="{{ route(Str::replace('*', '', $item['route'])) }}" 
                        class="group relative flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 
                        {{ $isActive 
                            ? 'bg-getmyname-50 text-getmyname-600 dark:bg-getmyname-900/20 dark:text-getmyname-400 font-semibold shadow-sm' 
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100' 
                        }}"
                    >
                        <div class="flex-shrink-0 flex items-center justify-center w-6 h-6">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        
                        <span 
                            class="ml-3 whitespace-nowrap overflow-hidden transition-all duration-300"
                            :class="sidebarExpanded ? 'opacity-100 w-auto' : 'opacity-0 w-0'"
                        >
                            {{ $item['label'] }}
                        </span>

                        <!-- Tooltip with High Z-Index -->
                        <div 
                            x-show="!sidebarExpanded"
                            class="absolute left-16 z-[100] w-max invisible group-hover:visible px-2 py-1"
                        >
                            <div class="px-3 py-1.5 text-sm font-medium text-white bg-gray-900 dark:bg-gray-700 rounded-lg shadow-lg relative">
                                {{ $item['label'] }}
                                <!-- Arrow -->
                                <div class="absolute top-1/2 -left-1 -mt-1 w-2 h-2 bg-gray-900 dark:bg-gray-700 transform rotate-45"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </nav>
            
            {{--<!-- User Footer -->
            <div class="flex-shrink-0 p-4 border-t border-gray-100 dark:border-gray-700/50" :class="!sidebarExpanded ? 'flex justify-center' : ''">
                <div class="flex items-center gap-3">
                    <img class="h-8 w-8 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700" src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}" />
                    <div class="flex-1 min-w-0" x-show="sidebarExpanded" x-transition>
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ __('View Profile') }}</p>
                    </div>
                </div>
            </div>--}}
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 bg-transparent">
             @if(View::hasSection('header') || View::hasSection('header_content'))
                <header class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-30">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @if(View::hasSection('header_content'))
                            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                @yield('header_content')
                            </h2>
                        @else
                            @yield('header')
                        @endif
                    </div>
                </header>
            @endif

            <div class="py-12 px-4 sm:px-6 lg:px-8">
                @if(View::hasSection('content_inner'))
                     <div class="max-w-5xl mx-auto">
                        <div class="bg-white/70 dark:bg-gray-800/60 backdrop-blur-sm shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl ring-1 ring-gray-900/5 dark:ring-white/10 overflow-hidden">
                             <div class="p-6 sm:p-10">
                                @yield('content_inner')
                             </div>
                        </div>
                     </div>
                @else
                    @yield('content')
                @endif
            </div>
        </main>
    </div>

    @if (!isset($hideFooter) || $hideFooter !== true)
        @include('components.footer')
    @endif
    
    @stack('scripts')
</body>
</html>