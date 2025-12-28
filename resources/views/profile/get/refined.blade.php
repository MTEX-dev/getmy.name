@php
    $get = fn($key, $default = null) => data_get($data, $key, $default);

    $formatDate = function ($date, $current = false) {
        if (!$date && $current) return 'Present';
        if (!$date) return null;
        try {
            return \Carbon\Carbon::parse($date)->format('M Y');
        } catch (\Throwable $e) {
            return $date;
        }
    };

    $socials = [
        'github' => [
            'svg' => '<path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>', 
            'label' => 'GitHub', 
            'prefix' => 'https://github.com/'
        ],
        'linkedin' => [
            'svg' => '<path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>', 
            'label' => 'LinkedIn', 
            'prefix' => 'https://www.linkedin.com/in/'
        ],
        'twitter' => [
            'svg' => '<path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>', 
            'label' => 'X', 
            'prefix' => 'https://x.com/'
        ],
        'personal_website' => [
            'svg' => '<path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1 14.808l-2.072-1.382c-.105-.07-.128-.213-.053-.311l.972-1.296c.074-.099.215-.121.316-.048l1.411 1.03 2.502-3.13c.092-.114.256-.129.367-.033l1.1 0.941c.11.096.126.26.035.374l-3.9 4.875c-.131.164-.378.163-.507-.02l-.171-.2z"/>', 
            'label' => 'Website', 
            'prefix' => ''
        ],
    ];

    $buildUrl = function($key, $val) use ($socials) {
        if (str_starts_with($val, 'http')) return $val;
        return ($socials[$key]['prefix'] ?? '') . ltrim($val, '@');
    };

    $name = $get('name', 'Developer');
    $title = $get('title', 'Portfolio'); 
    $bio = $get('bio');
    $avatar = $get('avatar_url');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $name }} — {{ $title }}</title>
    <meta name="description" content="{{ Str::limit($bio, 160) }}">
    
    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $name }}">
    <meta property="og:description" content="{{ Str::limit($bio, 160) }}">
    <meta property="og:image" content="{{ $avatar }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">
    @if($handle = $get('socials.twitter'))
        <meta name="twitter:creator" content="{{ '@' . ltrim($handle, '@') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 antialiased transition-colors duration-300">

    <div class="fixed inset-0 -z-10 h-full w-full bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] dark:bg-[radial-gradient(#1f2937_1px,transparent_1px)] dark:[mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-50 pointer-events-none"></div>

    <header 
        x-data="{ scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white/70 dark:bg-gray-950/70 shadow-sm backdrop-blur-md' : 'bg-transparent'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-transparent"
        :class="{ 'border-gray-200 dark:border-gray-800': scrolled }"
    >
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="#top" class="flex items-center gap-3 group">
                <div class="relative h-9 w-9 overflow-hidden rounded-full ring-2 ring-white dark:ring-gray-800 shadow-sm transition-transform group-hover:scale-105">
                    <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover">
                </div>
                <span class="font-bold text-lg tracking-tight group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $name }}</span>
            </a>

            <div class="flex items-center gap-4">
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600 dark:text-gray-400">
                    @if(count($get('projects', []))) <a href="#projects" class="hover:text-gray-900 dark:hover:text-white transition-colors">Projects</a> @endif
                    @if(count($get('experiences', []))) <a href="#experience" class="hover:text-gray-900 dark:hover:text-white transition-colors">Experience</a> @endif
                </nav>

                <div class="h-4 w-px bg-gray-200 dark:bg-gray-800 hidden md:block"></div>

                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        class="p-2 w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                        onclick="localStorage.theme === 'dark' ? localStorage.theme = 'light' : localStorage.theme = 'dark'; if (localStorage.theme === 'dark') { document.documentElement.classList.add('dark') } else { document.documentElement.classList.remove('dark') }"
                    >
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    @auth
                        <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                            <button @click="open = !open" class="h-8 w-8 rounded-full overflow-hidden ring-2 ring-gray-100 dark:ring-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <img src="{{ Auth::user()->avatar() }}" alt="User" class="h-full w-full object-cover">
                            </button>
                            <div x-show="open" 
                                 x-transition.origin.top.right
                                 class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-gray-900 shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-gray-800 py-1 focus:outline-none" 
                                 style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 dark:border-gray-800">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 pt-32 pb-20 space-y-24">
        
        <section id="top" class="animate-fade-in-up">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-8">
                <div class="space-y-6 max-w-lg">
                    <div class="space-y-2">
                        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            {{ $name }}
                        </h1>
                        <p class="text-xl font-medium text-primary-600 dark:text-primary-400">
                            {{ $title }}
                        </p>
                    </div>
                    
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $bio }}
                    </p>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                        @if($loc = $get('location'))
                            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800/50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                {{ $loc }}
                            </div>
                        @endif
                        @if($email = $get('email'))
                            <a href="mailto:{{ $email }}" class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800/50 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                {{ $email }}
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        @foreach($socials as $key => $conf)
                            @if($handle = $get("socials.$key"))
                                <a href="{{ $buildUrl($key, $handle) }}" target="_blank" rel="noopener noreferrer" 
                                   class="h-10 w-10 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-800 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-600 transition-all bg-white dark:bg-gray-900 shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">{!! $conf['svg'] !!}</svg>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-primary-500/10 dark:bg-primary-400/10 blur-2xl rounded-full"></div>
                    <img src="{{ $avatar }}" alt="{{ $name }}" class="relative h-32 w-32 md:h-40 md:w-40 rounded-2xl object-cover shadow-xl rotate-3 ring-1 ring-white/10 dark:ring-white/5">
                </div>
            </div>
        </section>

        @if($about = $get('about_me'))
            <section class="scroll-mt-24 space-y-6">
                <h2 class="text-2xl font-bold tracking-tight">About</h2>
                <div class="prose prose-gray dark:prose-invert max-w-none prose-p:leading-relaxed">
                    {!! nl2br(e($about)) !!}
                </div>
            </section>
        @endif

        @if($skills = $get('skills'))
            <section class="space-y-6">
                <h2 class="text-2xl font-bold tracking-tight">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-transparent hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-default">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </section>
        @endif

        @if($experiences = $get('experiences'))
            <section id="experience" class="scroll-mt-24 space-y-8">
                <h2 class="text-2xl font-bold tracking-tight">Work Experience</h2>
                <div class="relative border-l-2 border-gray-200 dark:border-gray-800 ml-3 space-y-12">
                    @foreach($experiences as $exp)
                        <div class="relative pl-8 group">
                            <div class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full border-2 border-white dark:border-gray-950 bg-gray-200 dark:bg-gray-700 group-hover:bg-primary-500 group-hover:scale-110 transition-all"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exp['title'] }}</h3>
                                <span class="text-sm font-mono text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $formatDate($exp['start_date']) }} — {{ $formatDate($exp['end_date'], true) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                <span>{{ $exp['company'] }}</span>
                                @if(!empty($exp['location']))
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-500">{{ $exp['location'] }}</span>
                                @endif
                            </div>

                            @if(!empty($exp['description']))
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($projects = $get('projects'))
            <section id="projects" class="scroll-mt-24 space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold tracking-tight">Selected Projects</h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-xs font-bold">{{ count($projects) }}</span>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($projects as $project)
                        <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 transition-all hover:shadow-lg hover:border-gray-300 dark:hover:border-gray-700">
                            @if(!empty($project['image_path']))
                                <div class="aspect-[16/9] overflow-hidden bg-gray-100 dark:bg-gray-800">
                                    <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @endif
                            
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    @if($project['url'])
                                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">
                                            <span class="absolute inset-0"></span>
                                            {{ $project['title'] }}
                                        </a>
                                    @else
                                        {{ $project['title'] }}
                                    @endif
                                </h3>
                                
                                @if(!empty($project['description']))
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ $project['description'] }}</p>
                                @endif

                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    @if($project['url'])
                                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400 flex items-center gap-1">
                                            Visit Project <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M7 17L17 7M17 7H7M17 7V17"/></svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($education = $get('education'))
            <section class="space-y-8 border-t border-gray-100 dark:border-gray-800 pt-10">
                <h2 class="text-xl font-bold tracking-tight">Education</h2>
                <div class="space-y-6">
                    @foreach($education as $edu)
                        <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $edu['school'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $edu['degree'] }}@if($edu['degree'] && $edu['field_of_study']), @endif{{ $edu['field_of_study'] }}
                                </p>
                            </div>
                            <div class="text-sm font-mono text-gray-500">
                                {{ $formatDate($edu['start_date']) }} — {{ $formatDate($edu['end_date']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ $name }}. All rights reserved.</p>
                
                <div class="flex items-center gap-4">
                    @if($reqCount = $get('api_request_count'))
                        <span class="font-mono text-xs opacity-70 flex items-center gap-1" title="API Hits">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            {{ number_format($reqCount) }}
                        </span>
                    @endif
                    <a href="https://mtex.dev" target="_blank" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">mtex.dev</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>