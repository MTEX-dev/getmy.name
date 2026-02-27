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
    
    // Refactored to use Lucide icon names
    $socials = [
        'github' => [
            'icon' => 'github',
            'label' => 'GitHub',
            'prefix' => 'https://github.com/',
        ],
        'linkedin' => [
            'icon' => 'linkedin',
            'label' => 'LinkedIn',
            'prefix' => 'https://www.linkedin.com/in/',
        ],
        'twitter' => [
            'icon' => 'twitter',
            'label' => 'X',
            'prefix' => 'https://x.com/',
        ],
        'bluesky' => [
            'icon' => 'cloud', // Lucide generic
            'label' => 'Bluesky',
            'prefix' => 'https://bsky.app/profile/',
        ],
        'personal_website' => [
            'icon' => 'globe',
            'label' => 'Website',
            'prefix' => '',
        ],
        'codepen' => [
            'icon' => 'pen-square', // Lucide generic
            'label' => 'CodePen',
            'prefix' => 'https://codepen.io/',
        ],
        'instagram' => [
            'icon' => 'instagram',
            'label' => 'Instagram',
            'prefix' => 'https://www.instagram.com/',
        ],
        'youtube_url' => [
            'icon' => 'youtube',
            'label' => 'YouTube',
            'prefix' => '',
        ],
        'stackoverflow' => [
            'icon' => 'layers', // Lucide generic
            'label' => 'Stack Overflow',
            'prefix' => 'https://stackoverflow.com/users/',
        ],
        'dev_to' => [
            'icon' => 'terminal-square', // Lucide generic
            'label' => 'DEV',
            'prefix' => 'https://dev.to/',
        ],
        'hashnode' => [
            'icon' => 'newspaper', // Lucide generic
            'label' => 'Hashnode',
            'prefix' => 'https://hashnode.com/@',
        ],
        'npm' => [
            'icon' => 'package', // Lucide generic
            'label' => 'npm',
            'prefix' => 'https://www.npmjs.com/~',
        ],
        'product_hunt' => [
            'icon' => 'rocket', // Lucide generic
            'label' => 'Product Hunt',
            'prefix' => 'https://www.producthunt.com/@',
        ],
        'polywork' => [
            'icon' => 'layout-grid', // Lucide generic
            'label' => 'Polywork',
            'prefix' => 'https://www.polywork.com/',
        ],
        'gitlab' => [
            'icon' => 'git-branch', // Lucide generic (GitLab not in default set)
            'label' => 'GitLab',
            'prefix' => 'https://gitlab.com/',
        ],
        'dribbble' => [
            'icon' => 'palette', // Lucide generic
            'label' => 'Dribbble',
            'prefix' => 'https://dribbble.com/',
        ],
        'figma' => [
            'icon' => 'component', // Lucide generic
            'label' => 'Figma',
            'prefix' => 'https://www.figma.com/@',
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
    <script src="https://unpkg.com/lucide@latest"></script>

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
                        <i data-lucide="sun" class="w-5 h-5 hidden dark:block"></i>
                        <i data-lucide="moon" class="w-5 h-5 block dark:hidden"></i>
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
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                {{ $loc }}
                            </div>
                        @endif
                        @if($email = $get('email'))
                            <a href="mailto:{{ $email }}" class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800/50 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 transition-colors">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                                {{ $email }}
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        @foreach($socials as $key => $conf)
                            @if($handle = $get("socials.$key"))
                                <a href="{{ $buildUrl($key, $handle) }}" target="_blank" rel="noopener noreferrer" 
                                   class="h-10 w-10 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-800 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-600 transition-all bg-white dark:bg-gray-900 shadow-sm">
                                    <i data-lucide="{{ $conf['icon'] }}" class="w-5 h-5"></i>
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
                                            Visit Project <i data-lucide="external-link" class="w-3 h-3"></i>
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
                            <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                            {{ number_format($reqCount) }}
                        </span>
                    @endif
                    <a href="https://mtex.dev" target="_blank" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">mtex.dev</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>