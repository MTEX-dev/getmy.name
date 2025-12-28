@php
    $get = fn($key, $default = null) => data_get($data, $key, $default);

    $fmtDate = function ($date, $fallback = '—') {
        if (empty($date)) return $fallback;
        try {
            $year = (int) substr($date, 0, 4);
            if ($year < 1900 || $year > 2100) return $fallback;
            return \Carbon\Carbon::parse($date)->isoFormat('MMM D, YYYY');
        } catch (\Throwable $e) {
            return $fallback;
        }
    };

    $socialMap = [
        'github' => [
            'GitHub', 'bi-github', function ($v) { return str_starts_with($v, 'http') ? $v : 'https://github.com/' . ltrim($v, '@'); }
        ],
        'linkedin' => [
            'LinkedIn', 'bi-linkedin', function ($v) { return str_starts_with($v, 'http') ? $v : 'https://www.linkedin.com/in/' . ltrim($v, '@'); }
        ],
        'twitter' => [
            'Twitter / X', 'bi-twitter-x', function ($v) {
                $handle = ltrim($v, '@');
                return str_starts_with($v, 'http') ? $v : 'https://x.com/' . $handle;
            }
        ],
        'personal_website' => [
            'Website', 'bi-globe2', function ($v) { return $v; }
        ],
    ];

    $title = $get('name', 'Developer') . ' — Portfolio';
    $description = Str::limit($get('bio', 'A developer\'s portfolio.'), 160);
    $imageUrl = $get('avatar_url');
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>

    <meta name="description" content="{{ $description }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $imageUrl }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image" content="{{ $imageUrl }}">
    @if($get('socials.twitter'))
        <meta name="twitter:creator" content="{{ '@' . ltrim($get('socials.twitter'), '@') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>

    <script>
        (function() {
            const applyTheme = (mode) => {
                const root = document.documentElement;
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const shouldDark = mode === 'dark' || (mode === 'system' && systemPrefersDark);
                root.classList.toggle('dark', shouldDark);
                root.dataset.theme = mode;
            };

            const saved = localStorage.getItem('theme') || 'dark';
            applyTheme(saved);

            window.__setTheme = function(mode) {
                localStorage.setItem('theme', mode);
                applyTheme(mode);
                document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                    btn.classList.toggle('bg-emerald-500/20', btn.dataset.themeBtn === mode);
                    btn.classList.toggle('text-emerald-400', btn.dataset.themeBtn === mode);
                });
            };

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const current = localStorage.getItem('theme') || 'system';
                if (current === 'system') applyTheme('system');
            });
        })();
    </script>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-black dark:text-gray-100 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Terminal Header -->
        <header class="sticky top-0 z-40 bg-gray-100 dark:bg-gray-950 border-b-2 border-gray-300 dark:border-emerald-500/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-14 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400">
                        <span class="text-lg">▶</span>
                        <span class="text-sm font-semibold tracking-tight">portfolio://{{ $get('username', 'user') }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @auth
                            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                                <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 bg-gray-200 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors text-sm">
                                    <img src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}" class="h-5 w-5 object-cover" />
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="h-3 w-3" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 origin-top-right bg-gray-100 dark:bg-gray-950 border-2 border-gray-300 dark:border-emerald-500/30 shadow-lg" style="display: none;">
                                    <div class="border-b border-gray-300 dark:border-gray-800 p-3">
                                        <div class="text-xs text-emerald-600 dark:text-emerald-400">USER_ID: {{ Auth::user()->id }}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="p-2">
                                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-xs hover:bg-gray-200 dark:hover:bg-gray-900 transition-colors">
                                            <span class="text-emerald-600 dark:text-emerald-400">$</span> edit-profile
                                        </a>
                                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-xs hover:bg-gray-200 dark:hover:bg-gray-900 transition-colors">
                                            <span class="text-emerald-600 dark:text-emerald-400">$</span> dashboard
                                        </a>
                                        <a href="{{ route('profile.preview') }}" class="block px-3 py-2 text-xs hover:bg-gray-200 dark:hover:bg-gray-900 transition-colors">
                                            <span class="text-emerald-600 dark:text-emerald-400">$</span> preview
                                        </a>
                                    </div>
                                    <div class="border-t border-gray-300 dark:border-gray-800 p-2">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-3 py-2 text-xs text-red-600 dark:text-red-400 hover:bg-gray-200 dark:hover:bg-gray-900 transition-colors">
                                                <span>$</span> logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <div class="flex items-center gap-1 bg-gray-200 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-1">
                            <button data-theme-btn="light" onclick="__setTheme('light')" class="h-7 w-7 inline-flex items-center justify-center text-xs hover:bg-gray-300 dark:hover:bg-gray-800 transition-colors" title="Light">
                                <i class="bi bi-sun"></i>
                            </button>
                            <button data-theme-btn="dark" onclick="__setTheme('dark')" class="h-7 w-7 inline-flex items-center justify-center text-xs hover:bg-gray-300 dark:hover:bg-gray-800 transition-colors" title="Dark">
                                <i class="bi bi-moon"></i>
                            </button>
                            <button data-theme-btn="system" onclick="__setTheme('system')" class="h-7 w-7 inline-flex items-center justify-center text-xs hover:bg-gray-300 dark:hover:bg-gray-800 transition-colors" title="System">
                                <i class="bi bi-circle-half"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main id="top" class="flex-1">
            <!-- Hero Section -->
            <section class="py-12 border-b-2 border-gray-300 dark:border-emerald-500/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-start gap-6">
                        <div class="hidden sm:block h-32 w-32 border-2 border-gray-300 dark:border-emerald-500/50 overflow-hidden">
                            <img src="{{ $get('avatar_url') }}" alt="{{ $get('name') }} avatar" class="h-full w-full object-cover" />
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 mb-2">
                                <span class="opacity-50">connecting to database...</span>
                                <span class="animate-pulse">▊</span>
                            </div>
                            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $get('name') }}
                            </h1>
                            @if($get('title'))
                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    <span class="text-emerald-600 dark:text-emerald-400">ROLE:</span> {{ $get('title') }}
                                </div>
                            @endif
                            @if($get('location'))
                                <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                    <span class="text-emerald-600 dark:text-emerald-400">LOCATION:</span> {{ $get('location') }}
                                </div>
                            @endif
                            @if($get('email'))
                                <div class="mt-1 text-sm">
                                    <span class="text-emerald-600 dark:text-emerald-400">CONTACT:</span> 
                                    <a href="mailto:{{ $get('email') }}" class="text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 underline">{{ $get('email') }}</a>
                                </div>
                            @endif
                            @if($get('bio'))
                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 max-w-3xl">
                                    <span class="text-emerald-600 dark:text-emerald-400">&gt;</span> {{ $get('bio') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social Links -->
                    @php $socials = array_filter($socialMap, fn($key) => !empty($get('socials.' . $key)), ARRAY_FILTER_USE_KEY); @endphp
                    @if(!empty($socials))
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($socials as $key => [$label, $icon, $urlBuilder])
                                @php 
                                    $val = $get('socials.' . $key);
                                    $href = $urlBuilder($val);
                                @endphp
                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" 
                                   class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-200 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 text-xs transition-colors">
                                    <i class="bi {{ $icon }}"></i>
                                    <span>{{ $label }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- About Section -->
            @if($get('about_me'))
                <section class="py-12 border-b-2 border-gray-300 dark:border-emerald-500/30">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-xl font-bold mb-4 text-emerald-600 dark:text-emerald-400">
                            <span class="text-gray-400 dark:text-gray-600">$</span> SELECT * FROM about_me;
                        </h2>
                        <div class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 p-6">
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $get('about_me') }}
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-500 dark:text-gray-600">
                            Query OK, 1 row returned
                        </div>
                    </div>
                </section>
            @endif

            <!-- Skills Section -->
            <section class="py-12 border-b-2 border-gray-300 dark:border-emerald-500/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-bold mb-4 text-emerald-600 dark:text-emerald-400">
                        <span class="text-gray-400 dark:text-gray-600">$</span> SELECT * FROM skills;
                    </h2>
                    <div class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800">
                        <div class="border-b border-gray-300 dark:border-gray-800 p-3 text-xs text-gray-600 dark:text-gray-500">
                            <span class="inline-block w-12">ID</span>
                            <span>SKILL_NAME</span>
                        </div>
                        @forelse($get('skills', []) as $index => $skill)
                            <div class="border-b border-gray-300 dark:border-gray-800 p-3 text-sm hover:bg-gray-200 dark:hover:bg-gray-900 transition-colors">
                                <span class="inline-block w-12 text-gray-500 dark:text-gray-600">{{ $index + 1 }}</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $skill }}</span>
                            </div>
                        @empty
                            <div class="p-3 text-sm text-gray-500">Empty set (0.00 sec)</div>
                        @endforelse
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-600">
                        {{ count($get('skills', [])) }} row(s) in set
                    </div>
                </div>
            </section>

            <!-- Projects Section -->
            <section class="py-12 border-b-2 border-gray-300 dark:border-emerald-500/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-bold mb-4 text-emerald-600 dark:text-emerald-400">
                        <span class="text-gray-400 dark:text-gray-600">$</span> SELECT * FROM projects;
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($get('projects', []) as $project)
                            <article class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 overflow-hidden hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors group">
                                <div class="aspect-[16/9] bg-gray-200 dark:bg-gray-900 border-b border-gray-300 dark:border-gray-800 flex items-center justify-center overflow-hidden">
                                    @if(!empty($project['image_path']))
                                        <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project' }}" class="h-full w-full object-cover" />
                                    @else
                                        <i class="bi bi-file-code text-4xl text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <div class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">
                                        PROJECT_ID: {{ $project['id'] ?? '—' }}
                                    </div>
                                    <h3 class="font-semibold text-base text-gray-900 dark:text-white">
                                        {{ $project['title'] ?? $project['name'] ?? 'Untitled' }}
                                    </h3>
                                    @if(!empty($project['description']))
                                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 line-clamp-3">
                                            {{ $project['description'] }}
                                        </p>
                                    @endif
                                    @if(!empty($project['url']))
                                        <div class="mt-3">
                                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" 
                                               class="inline-flex items-center gap-1 text-xs text-emerald-600 dark:text-emerald-400 hover:underline">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                                <span>view-project</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 p-6 text-center text-sm text-gray-500">
                                Empty set (0.00 sec)
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-600">
                        {{ count($get('projects', [])) }} row(s) in set
                    </div>
                </div>
            </section>

            <!-- Experience Section -->
            <section class="py-12 border-b-2 border-gray-300 dark:border-emerald-500/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-bold mb-4 text-emerald-600 dark:text-emerald-400">
                        <span class="text-gray-400 dark:text-gray-600">$</span> SELECT * FROM experience ORDER BY start_date DESC;
                    </h2>
                    <div class="space-y-4">
                        @forelse($get('experiences', []) as $exp)
                            <article class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 p-5 hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors">
                                <div class="flex flex-wrap justify-between gap-3 mb-2">
                                    <div>
                                        <h3 class="font-semibold text-base text-gray-900 dark:text-white">
                                            {{ $exp['title'] ?? 'Role' }}
                                        </h3>
                                        <div class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                            <span class="text-emerald-600 dark:text-emerald-400">@</span> {{ $exp['company'] ?? 'Company' }}
                                            @if(!empty($exp['location']))
                                                <span class="text-gray-500 mx-2">|</span>
                                                <span class="text-gray-600 dark:text-gray-400">{{ $exp['location'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-600">
                                        {{ $fmtDate($exp['start_date'] ?? null) }} → {{ $fmtDate($exp['end_date'] ?? null, 'Present') }}
                                    </div>
                                </div>
                                @if(!empty($exp['description']))
                                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $exp['description'] }}
                                    </p>
                                @endif
                            </article>
                        @empty
                            <div class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 p-6 text-center text-sm text-gray-500">
                                Empty set (0.00 sec)
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-600">
                        {{ count($get('experiences', [])) }} row(s) in set
                    </div>
                </div>
            </section>

            <!-- Education Section -->
            <section class="py-12 border-b-2 border-gray-300 dark:border-emerald-500/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-bold mb-4 text-emerald-600 dark:text-emerald-400">
                        <span class="text-gray-400 dark:text-gray-600">$</span> SELECT * FROM education ORDER BY start_date DESC;
                    </h2>
                    <div class="space-y-4">
                        @forelse($get('education', []) as $edu)
                            <article class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 p-5 hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors">
                                <div class="flex flex-wrap justify-between gap-3 mb-2">
                                    <div>
                                        <h3 class="font-semibold text-base text-gray-900 dark:text-white">
                                            {{ $edu['school'] ?? 'School' }}
                                        </h3>
                                        <div class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                            @if(!empty($edu['degree']))
                                                <span class="text-emerald-600 dark:text-emerald-400">DEGREE:</span> {{ $edu['degree'] }}
                                            @endif
                                            @if(!empty($edu['field_of_study']))
                                                <span class="text-gray-500 mx-2">|</span>
                                                <span class="text-emerald-600 dark:text-emerald-400">FIELD:</span> {{ $edu['field_of_study'] }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-600">
                                        {{ $fmtDate($edu['start_date'] ?? null) }} → {{ $fmtDate($edu['end_date'] ?? null) }}
                                    </div>
                                </div>
                                @if(!empty($edu['description']))
                                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $edu['description'] }}
                                    </p>
                                @endif
                            </article>
                        @empty
                            <div class="bg-gray-100 dark:bg-gray-950 border border-gray-300 dark:border-gray-800 p-6 text-center text-sm text-gray-500">
                                Empty set (0.00 sec)
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-600">
                        {{ count($get('education', [])) }} row(s) in set
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="border-t-2 border-gray-300 dark:border-emerald-500/30 bg-gray-100 dark:bg-gray-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-wrap justify-between items-center gap-4 text-xs text-gray-600 dark:text-gray-500">
                    <div>
                        <span class="text-emerald-600 dark:text-emerald-400">$</span> Powered by 
                        <a class="text-emerald-600 dark:text-emerald-400 hover:underline" href="https://getmy.name" target="_blank" rel="noopener">getmy.name</a>
                        <span class="mx-1">|</span>
                        <a class="text-emerald-600 dark:text-emerald-400 hover:underline" href="https://mtex.dev" target="_blank" rel="noopener">mtex.dev</a>
                    </div>
                    @if($get('api_request_count'))
                        <div>
                            <span class="text-emerald-600 dark:text-emerald-400">API_REQUESTS:</span> {{ number_format($get('api_request_count')) }}
                        </div>
                    @endif
                </div>
            </div>
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const current = localStorage.getItem('theme') || 'dark';
            document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                btn.classList.toggle('bg-emerald-500/20', btn.dataset.themeBtn === current);
                btn.classList.toggle('text-emerald-400', btn.dataset.themeBtn === current);
            });
        });
    </script>
</body>
</html>