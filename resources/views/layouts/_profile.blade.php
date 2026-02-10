<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MTEX.dev') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom Scrollbar for Sidebar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body 
    class="font-sans antialiased flex flex-col min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100"
    x-data="{ 
        sidebarOpen: window.innerWidth >= 1024, 
        sidebarExpanded: localStorage.getItem('sidebarExpanded') === 'true',
        toggleSidebar() {
            if (window.innerWidth >= 1024) {
                this.sidebarExpanded = !this.sidebarExpanded;
                localStorage.setItem('sidebarExpanded', this.sidebarExpanded);
            } else {
                this.sidebarOpen = !this.sidebarOpen;
            }
        }
    }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebarExpanded', value))"
>
    
    @include('components.navbar')
    @include('components.toast-messages')

    <!-- Ambient Background Gradient -->
    <div class="fixed top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-50/50 via-purple-50/30 to-transparent dark:from-blue-900/20 dark:via-purple-900/10 dark:to-transparent -z-50 pointer-events-none"></div>

    <div class="flex flex-1 pt-16 relative">
        
        <!-- Mobile Backdrop -->
        <div 
            x-show="sidebarOpen && window.innerWidth < 1024" 
            x-transition.opacity 
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-gray-900/50 z-30 lg:hidden backdrop-blur-sm"
        ></div>

        <!-- Sidebar -->
        <aside 
            :class="[
                sidebarExpanded ? 'w-72' : 'w-20',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
            ]"
            class="fixed lg:sticky top-16 z-40 h-[calc(100vh-4rem)] bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-r border-gray-200 dark:border-gray-800 transition-all duration-300 ease-in-out flex flex-col group/sidebar"
        >
            <!-- Navigation Items Logic -->
            @php
                $navItems = [
                    ['route' => 'profile.edit', 'label' => __('profile.profile'), 'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
                    ['route' => 'profile.password', 'label' => __('profile.password'), 'icon' => 'M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z'],
                    ['route' => 'profile.avatar', 'label' => __('profile.avatar'), 'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z'],
                    ['route' => 'profile.design', 'label' => __('profile.design'), 'icon' => 'M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.635m0 0a3.375 3.375 0 0 1-2.316-2.922 4.5 4.5 0 0 0-5.69-5.69A3.375 3.375 0 0 1 6.556 3.65 4.5 4.5 0 0 0 2.25 8.188a3.375 3.375 0 0 1 2.922 2.316 15.993 15.993 0 0 0 4.635 4.764L19.5 21 21 19.5l-2.657-2.657Z'],
                    ['route' => 'profile.skills', 'label' => __('profile.skills'), 'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z'],
                    ['route' => 'profile.projects', 'label' => __('profile.projects.title'), 'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.67.38m-4.5-8.393c-2.087-.277-4.216-.42-6.378-.42s-4.291.143-6.378.42m12.756 0a48.11 48.11 0 0 0-3.413.387m-4.5 8.006c.194.165.42.295.67.38m0 0c.459.155.94.246 1.436.276a49.925 49.925 0 0 0 6.31 0c.496-.03.976-.12 1.436-.276m0 0a2.18 2.18 0 0 0 .67-.38m-13.432 0c.459.155.94.246 1.436.276a49.925 49.925 0 0 0 6.31 0c.496-.03.976-.12 1.436-.276m0 0a2.18 2.18 0 0 0 .67-.38m-13.432 0C2.988 15.683 1.5 13.843 1.5 12c0-1.844 1.488-3.684 3.032-4.197m4.5 8.393a2.18 2.18 0 0 0-.67.38m-4.5-8.393c.459-.155.94-.246 1.436-.276a49.92 49.92 0 0 0 6.31 0c.496.03.976.12 1.436.276m0 0a2.18 2.18 0 0 0-.67-.38m13.432 0a2.18 2.18 0 0 1-.67.38m-12.756 0c.194.165.42.295.67.38'],
                    ['route' => 'profile.education', 'label' => __('profile.education'), 'icon' => 'M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.416 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.782.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5'],
                    ['route' => 'profile.socials', 'label' => __('profile.socials.title'), 'icon' => 'M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418'],
                    ['route' => 'profile.activity', 'label' => __('profile.activity.title'), 'icon' => 'M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605']
                ];
            @endphp

            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100 dark:border-gray-800/50 shrink-0">
                <span 
                    x-show="sidebarExpanded" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="font-bold text-lg tracking-tight text-gray-800 dark:text-white"
                >
                    {{ __('profile.profile') }}
                </span>
                
                <!-- Toggle Button -->
                <button 
                    @click="toggleSidebar()" 
                    class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none"
                    :class="sidebarExpanded ? '' : 'mx-auto'"
                >
                    <svg x-show="sidebarExpanded" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                    <svg x-show="!sidebarExpanded" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto no-scrollbar p-3 space-y-1">
                @foreach($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route']);
                    @endphp
                    
                    <a 
                        href="{{ route($item['route']) }}" 
                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 outline-none
                            {{ $isActive 
                                ? 'bg-getmyname-50/80 dark:bg-getmyname-900/20 text-getmyname-700 dark:text-getmyname-400 font-semibold shadow-sm ring-1 ring-getmyname-200 dark:ring-transparent' 
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-gray-200' 
                            }}"
                    >
                        <!-- Active Indicator (Left Bar) -->
                        <div 
                            class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-getmyname-500 rounded-r-full transition-all duration-300"
                            :class="sidebarExpanded ? 'opacity-0' : ({{ $isActive ? '1' : '0' }} ? 'opacity-100' : 'opacity-0')"
                        ></div>

                        <!-- Icon -->
                        <svg class="w-6 h-6 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ $isActive ? 'text-getmyname-600 dark:text-getmyname-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>

                        <!-- Label (Expanded) -->
                        <span 
                            class="whitespace-nowrap transition-opacity duration-200"
                            :class="sidebarExpanded ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'"
                        >
                            {{ $item['label'] }}
                        </span>

                        <!-- Tooltip (Collapsed) -->
                        <div 
                            x-show="!sidebarExpanded"
                            class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3 py-1.5 bg-gray-900 text-white text-xs font-medium rounded-md opacity-0 -translate-x-2 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-x-0 transition-all duration-200 z-50 shadow-lg whitespace-nowrap pointer-events-none"
                        >
                            {{ $item['label'] }}
                            <!-- Tooltip Arrow -->
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 -ml-1 w-2 h-2 bg-gray-900 transform rotate-45"></div>
                        </div>
                    </a>
                @endforeach
            </nav>

            <!-- User/Footer Section of Sidebar -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-800/50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-getmyname-400 to-purple-500 shrink-0"></div>
                    <div :class="sidebarExpanded ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'" class="transition-all duration-300">
                        <p class="text-xs font-medium text-gray-900 dark:text-white truncate max-w-[150px]">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-500 truncate max-w-[150px]">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main 
            class="flex-1 transition-all duration-300 ease-in-out min-w-0"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-20'"
        >
            <!-- Sticky Mobile Header (if needed inside main content) -->
            <div class="lg:hidden flex items-center justify-between p-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
               <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
               </button>
               <span class="font-semibold text-gray-900 dark:text-white">Menu</span>
            </div>

            @if(View::hasSection('header') || View::hasSection('header_content'))
                <header class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700/50 sticky top-16 z-20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @if(View::hasSection('header_content'))
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                @yield('header_content')
                            </h2>
                        @else
                            @yield('header')
                        @endif
                    </div>
                </header>
            @endif

            <div class="py-8 px-4 sm:px-6 lg:px-8">
                @if(View::hasSection('content_inner'))
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                            <div class="p-6">
                                @yield('content_inner')
                            </div>
                        </div>
                    </div>
                @else
                    @yield('content')
                @endif
            </div>

            @if (!isset($hideFooter) || $hideFooter !== true)
                @include('components.footer')
            @endif
        </main>
    </div>

    @stack('scripts')
</body>
</html>