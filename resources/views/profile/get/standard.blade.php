<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $data['name'] }} (@ {{ $data['username'] }}) - {{ config('app.name', 'GetMyName') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 selection:bg-getmyname-500 selection:text-white transition-colors duration-300">

    <!-- Navigation / Theme Toggler -->
    <nav class="fixed w-full z-50 top-0 start-0 transition-all duration-300" 
         x-data="{ scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="scrolled ? 'bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm border-b border-gray-200 dark:border-gray-800' : 'bg-transparent border-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    @if($data['avatar_url'])
                        <img src="{{ $data['avatar_url'] }}" class="h-8 w-8 rounded-full ring-2 ring-getmyname-500" alt="{{ $data['name'] }}">
                    @endif
                    <span class="self-center text-xl font-bold whitespace-nowrap dark:text-white" 
                          :class="scrolled ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-2'"
                          class="transition-all duration-300">
                        {{ $data['name'] }}
                    </span>
                </a>
                
                <div class="flex items-center space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <!-- Theme Toggler (Provided Logic) -->
                    <div x-data="{
                        theme: localStorage.getItem('theme') || 'system',
                        init() {
                            this.setTheme(this.theme);
                            this.$watch('theme', value => this.setTheme(value));
                        },
                        setTheme(theme) {
                            if (theme === 'system') {
                                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                            } else if (theme === 'dark') {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                            localStorage.setItem('theme', theme);
                        },
                        toggleTheme() {
                            const themes = ['system', 'light', 'dark'];
                            const currentIndex = themes.indexOf(this.theme);
                            this.theme = themes[(currentIndex + 1) % themes.length];
                        }
                    }" class="relative inline-flex items-center justify-center ms-4">
                        <button @click="toggleTheme()"
                            class="w-10 aspect-square flex items-center justify-center
                                   rounded-xl cursor-pointer
                                   text-gray-500 dark:text-gray-400
                                   hover:bg-gray-100 dark:hover:bg-gray-800
                                   hover:text-getmyname-600 dark:hover:text-getmyname-400
                                   transition duration-200 ease-in-out focus:outline-none ring-1 ring-gray-200 dark:ring-gray-700">
                            <template x-if="theme === 'system'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </template>
                    
                            <template x-if="theme === 'dark'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            </template>
                    
                            <template x-if="theme === 'light'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="min-h-screen pt-24 pb-12 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto space-y-8">

            <!-- Hero Section -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden relative group">
                <!-- Decorative Gradient Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-getmyname-50/50 via-white to-white dark:from-getmyname-950/30 dark:via-gray-900 dark:to-gray-900 z-0"></div>
                
                <div class="relative z-10 p-8 md:p-12 flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-left">
                    <!-- Avatar -->
                    <div class="shrink-0 relative">
                        <div class="w-32 h-32 md:w-40 md:h-40 rounded-full p-1 bg-gradient-to-br from-gray-200 to-white dark:from-gray-700 dark:to-gray-800 shadow-xl">
                            <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="w-full h-full rounded-full object-cover border-4 border-white dark:border-gray-900">
                        </div>
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-900 rounded-full" title="Available for hire"></div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 space-y-4">
                        <div>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                                {{ $data['name'] }}
                            </h1>
                            <p class="text-lg text-getmyname-600 dark:text-getmyname-400 font-medium font-mono mt-1">
                                {{ '@' . $data['username'] }}
                            </p>
                        </div>

                        @if($data['title'])
                            <div class="flex items-center justify-center md:justify-start gap-2 text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span class="text-lg">{{ $data['title'] }}</span>
                            </div>
                        @endif

                        @if($data['location'])
                            <div class="flex items-center justify-center md:justify-start gap-2 text-gray-500 dark:text-gray-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $data['location'] }}</span>
                            </div>
                        @endif

                        @if($data['bio'])
                            <p class="text-gray-600 dark:text-gray-300 max-w-2xl text-base leading-relaxed">
                                {{ $data['bio'] }}
                            </p>
                        @endif

                        <!-- Social Links -->
                        @if(!empty($data['socials']))
                            <div class="flex flex-wrap gap-3 justify-center md:justify-start pt-2">
                                @foreach($data['socials'] as $key => $url)
                                    @if($url)
                                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" 
                                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-500 hover:text-getmyname-600 dark:hover:text-getmyname-400 hover:bg-white dark:hover:bg-gray-700 shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100 dark:border-gray-700">
                                            @include('profile.get.partials.social-icon', ['key' => $key])
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Stats (API) -->
                    <div class="hidden lg:block shrink-0 text-right">
                        <div class="inline-flex flex-col items-center p-4 bg-white/50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">API Hits</span>
                            <span class="text-2xl font-black text-getmyname-600 dark:text-getmyname-400 font-mono">
                                {{ number_format($data['api_request_count']) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column (About & Skills) -->
                <div class="space-y-8">
                    <!-- About Me -->
                    @if($data['about_me'])
                    <section class="bg-white dark:bg-gray-900 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-800">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('About Me') }}
                        </h2>
                        <div class="prose dark:prose-invert prose-green max-w-none text-gray-600 dark:text-gray-300 text-sm">
                            {!! Str::markdown($data['about_me']) !!}
                        </div>
                    </section>
                    @endif

                    <!-- Skills -->
                    @if(!empty($data['skills']))
                    <section class="bg-white dark:bg-gray-900 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-800">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            {{ __('Skills & Tech') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($data['skills'] as $skill)
                                <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium hover:border-getmyname-400 transition-colors cursor-default">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </div>

                <!-- Right Column (Experience & Projects) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Projects -->
                    @if(!empty($data['projects']))
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                {{ __('Featured Projects') }}
                            </h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($data['projects'] as $project)
                            <a href="{{ $project['url'] ?: '#' }}" target="{{ $project['url'] ? '_blank' : '_self' }}" 
                               class="group bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-lg hover:border-getmyname-300 dark:hover:border-getmyname-700 transition-all duration-300 flex flex-col h-full">
                                
                                <div class="aspect-video w-full bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                    @if($project['image_path'])
                                        <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-700">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    
                                    @if($project['url'])
                                        <div class="absolute top-4 right-4 bg-white/90 dark:bg-gray-900/90 p-2 rounded-full opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 shadow-sm">
                                            <svg class="w-4 h-4 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-getmyname-600 transition-colors">{{ $project['title'] }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4 flex-1">
                                        {{ $project['description'] }}
                                    </p>
                                    @if($project['url'])
                                        <div class="text-xs font-semibold text-getmyname-600 dark:text-getmyname-400 flex items-center gap-1">
                                            {{ parse_url($project['url'], PHP_URL_HOST) }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Experience Timeline -->
                    @if(!empty($data['experiences']))
                    <section class="bg-white dark:bg-gray-900 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-800">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-2">
                            <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ __('Work Experience') }}
                        </h2>
                        
                        <div class="relative border-l-2 border-gray-100 dark:border-gray-800 ml-3 space-y-8">
                            @foreach($data['experiences'] as $exp)
                                <div class="relative pl-8">
                                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full border-2 border-white dark:border-gray-900 bg-gray-200 dark:bg-gray-700"></div>
                                    
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-baseline gap-1 mb-1">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $exp['title'] }}</h3>
                                        <span class="text-xs font-mono text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($exp['start_date'])->format('M Y') }} - 
                                            {{ $exp['end_date'] ? \Carbon\Carbon::parse($exp['end_date'])->format('M Y') : 'Present' }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm font-semibold text-getmyname-600 dark:text-getmyname-400 mb-2">
                                        {{ $exp['company'] }} @if($exp['location']) • {{ $exp['location'] }} @endif
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                        {{ $exp['description'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Education -->
                    @if(!empty($data['education']))
                    <section class="bg-white dark:bg-gray-900 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-gray-800">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-2">
                            <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            {{ __('Education') }}
                        </h2>
                        
                        <div class="relative border-l-2 border-gray-100 dark:border-gray-800 ml-3 space-y-8">
                            @foreach($data['education'] as $edu)
                                <div class="relative pl-8">
                                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full border-2 border-white dark:border-gray-900 bg-gray-200 dark:bg-gray-700"></div>
                                    
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-baseline gap-1 mb-1">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $edu['school'] }}</h3>
                                        <span class="text-xs font-mono text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($edu['start_date'])->format('Y') }} - 
                                            {{ $edu['end_date'] ? \Carbon\Carbon::parse($edu['end_date'])->format('Y') : 'Present' }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm font-semibold text-getmyname-600 dark:text-getmyname-400 mb-2">
                                        {{ $edu['degree'] }} @if($edu['field_of_study']) in {{ $edu['field_of_study'] }} @endif
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                        {{ $edu['description'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 mt-12 py-12">
        <div class="max-w-5xl mx-auto px-6 flex flex-col items-center justify-center gap-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} <span class="font-bold text-gray-900 dark:text-white">{{ $data['name'] }}</span>. All rights reserved.
            </p>
            <a href="{{ route('lander') }}" class="text-xs font-semibold text-getmyname-600 dark:text-getmyname-400 hover:underline flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Powered by {{ config('app.name', 'GetMyName') }}
            </a>
        </div>
    </footer>

    <!-- SVG Definitions for Social Icons (Inline to prevent dependency issues) -->
    <!-- You should create a partial, but for this standalone file we define a helper script or include them directly. 
         To keep it clean, we'll assume a blade component logic or inline switch. 
         For this response, I'll rely on a basic include or assume standard FontAwesome/Heroicons usage where appropriate, 
         but for the specific social icons, here is a clean way to handle it using a blade sub-view or inline switch.
    -->

</body>
</html>