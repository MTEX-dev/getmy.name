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
            'GitHub', 'github', function ($v) { return str_starts_with($v, 'http') ? $v : 'https://github.com/' . ltrim($v, '@'); }
        ],
        'linkedin' => [
            'LinkedIn', 'linkedin', function ($v) { return str_starts_with($v, 'http') ? $v : 'https://www.linkedin.com/in/' . ltrim($v, '@'); }
        ],
        'twitter' => [
            'Twitter / X', 'twitter', function ($v) {
                $handle = ltrim($v, '@');
                return str_starts_with($v, 'http') ? $v : 'https://x.com/' . $handle;
            }
        ],
        'bluesky' => [
            'Bluesky', 'cloud', fn($v) => str_starts_with($v, 'http') ? $v : 'https://bsky.app/profile/' . ltrim($v, '@'),
        ],
        'personal_website' => [
            'Website', 'globe', function ($v) { return $v; }
        ],
        'codepen' => [
            'CodePen', 'codepen', fn($v) => str_starts_with($v, 'http') ? $v : 'https://codepen.io/' . ltrim($v, '@'),
        ],
        'instagram' => [
            'Instagram', 'instagram', fn($v) => str_starts_with($v, 'http') ? $v : 'https://instagram.com/' . ltrim($v, '@'),
        ],
        'youtube_url' => [
            'YouTube', 'youtube', fn($v) => str_starts_with($v, 'http') ? $v : 'https://youtube.com/@' . ltrim($v, '@'),
        ],
        'stackoverflow' => [
            'Stack Overflow', 'layers', fn($v) => str_starts_with($v, 'http') ? $v : 'https://stackoverflow.com/users/' . $v,
        ],
        'npm' => [
            'NPM', 'package', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.npmjs.com/~' . ltrim($v, '@'),
        ],
        'dev_to' => [
            'Dev.to', 'terminal-square', fn($v) => str_starts_with($v, 'http') ? $v : 'https://dev.to/' . ltrim($v, '@'),
        ],
        'hashnode' => [
            'Hashnode', 'newspaper', fn($v) => str_starts_with($v, 'http') ? $v : 'https://hashnode.com/@' . ltrim($v, '@'),
        ],
        'product_hunt' => [
            'Product Hunt', 'rocket', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.producthunt.com/@' . ltrim($v, '@'),
        ],
        'polywork' => [
            'Polywork', 'layout-grid', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.polywork.com/' . ltrim($v, '@'),
        ],
        'gitlab' => [
            'GitLab', 'git-branch', fn($v) => str_starts_with($v, 'http') ? $v : 'https://gitlab.com/' . ltrim($v, '@'),
        ],
        'dribbble' => [
            'Dribbble', 'palette', fn($v) => str_starts_with($v, 'http') ? $v : 'https://dribbble.com/' . ltrim($v, '@'),
        ],
        'figma' => [
            'Figma', 'component', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.figma.com/@' . ltrim($v, '@'),
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

    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        (function() {
            const applyTheme = (mode) => {
                const root = document.documentElement;
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const shouldDark = mode === 'dark' || (mode === 'system' && systemPrefersDark);
                root.classList.toggle('dark', shouldDark);
                root.dataset.theme = mode;
            };

            const saved = localStorage.getItem('theme') || 'system';
            applyTheme(saved);

            window.__setTheme = function(mode) {
                localStorage.setItem('theme', mode);
                applyTheme(mode);
                document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                    btn.classList.toggle('ring-2', btn.dataset.themeBtn === mode);
                    btn.classList.toggle('ring-primary-500', btn.dataset.themeBtn === mode);
                });
            };

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const current = localStorage.getItem('theme') || 'system';
                if (current === 'system') applyTheme('system');
            });
        })();
    </script>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100 antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="sticky top-0 z-40 backdrop-blur supports-[backdrop-filter]:bg-white/50 dark:supports-[backdrop-filter]:bg-gray-950/50 border-b border-gray-200/70 dark:border-gray-800">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="#top" class="flex items-center gap-3 group">
                        <div class="h-9 w-9 rounded-xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-800 shadow-sm">
                            <img src="{{ $get('avatar_url') }}" alt="{{ $get('name') }} avatar" class="h-full w-full object-cover" />
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Portfolio</div>
                            <div class="font-semibold">{{ $get('name') }}</div>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 rounded-full border border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-gray-900/80 p-1 backdrop-blur-sm transition-all duration-200 hover:ring-2 hover:ring-primary-500">
                                <img src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full border border-gray-200 dark:border-gray-700 object-cover" />
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-600 dark:text-gray-400 transition-colors mr-1" :class="open && 'rotate-180'"></i>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-64 origin-top-right rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-xl" style="display: none;">
                                <div class="border-b border-gray-200 dark:border-gray-800 p-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full border border-gray-200 dark:border-gray-700 object-cover" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('profile.edit') }}" class="flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-700 dark:text-gray-300 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400">
                                        <i data-lucide="user" class="mr-3 h-4 w-4"></i>
                                        Profile
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-700 dark:text-gray-300 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400">
                                        <i data-lucide="layout-dashboard" class="mr-3 h-4 w-4"></i>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile.preview') }}" class="flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-700 dark:text-gray-300 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400">
                                        <i data-lucide="eye" class="mr-3 h-4 w-4"></i>
                                        Preview Portfolio
                                    </a>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-800 p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center rounded-md px-3 py-2 text-sm text-red-600 dark:text-red-400 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <i data-lucide="log-out" class="mr-3 h-4 w-4"></i>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth

                    <div class="relative">
                        <div class="flex items-center gap-1 rounded-full border border-gray-200 dark:border-gray-800 p-1 bg-white dark:bg-gray-900 shadow-sm">
                            <button data-theme-btn="light" onclick="__setTheme('light')" class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="Light">
                                <i data-lucide="sun" class="w-4 h-4"></i>
                            </button>
                            <button data-theme-btn="dark" onclick="__setTheme('dark')" class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="Dark">
                                <i data-lucide="moon" class="w-4 h-4"></i>
                            </button>
                            <button data-theme-btn="system" onclick="__setTheme('system')" class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="System">
                                <i data-lucide="laptop" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main id="top" class="flex-1 scroll-mt-16">
            <section class="py-10 sm:py-12">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-[auto,1fr] items-center gap-8">
                        <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-2xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-800 shadow-md">
                            <img src="{{ $get('avatar_url') }}" alt="{{ $get('name') }} avatar" class="h-full w-full object-cover" />
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight">{{ $get('name') }}</h1>
                            <p class="mt-1 text-lg text-primary-600 dark:text-primary-400 font-medium">
                                {{ $get('title') }}
                                @if($get('username') || $get('pronouns'))
                                    <span class="ml-1 text-gray-400 dark:text-gray-500 font-normal">
                                        &middot; 
                                        {{ $get('username') }}{{ $get('username') && $get('pronouns') ? ' · ' : '' }}{{ $get('pronouns') }}
                                    </span>
                                @endif
                            </p>
                            <p class="mt-4 max-w-3xl text-gray-600 dark:text-gray-300">{{ $get('bio') }}</p>
                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                @if($get('location'))
                                    <span class="inline-flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4"></i>{{ $get('location') }}</span>
                                @endif
                                @if($get('email'))
                                    <a href="mailto:{{ $get('email') }}" class="inline-flex items-center gap-2 hover:text-primary-600 dark:hover:text-primary-400"><i data-lucide="mail" class="w-4 h-4"></i>{{ $get('email') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-4">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap items-center gap-3">
                        @foreach($socialMap as $key => [$label, $icon, $urlBuilder])
                            @php $val = $get('socials.' . $key); @endphp
                            @if(!empty($val))
                                @php $href = $urlBuilder($val); @endphp
                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-gray-200 dark:border-gray-800 px-3 py-1.5 text-sm hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition">
                                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i><span>{{ $label }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>

            @if($get('about_me'))
                <section id="about" class="py-10 sm:py-12 border-t border-gray-200 dark:border-gray-800">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-xl sm:text-2xl font-semibold">About Me</h2>
                        <div class="mt-6 prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $get('about_me') }}</p>
                        </div>
                    </div>
                </section>
            @endif

            <section id="skills" class="py-10 sm:py-12 border-t border-gray-200 dark:border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl sm:text-2xl font-semibold">Skills</h2>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @forelse($get('skills', []) as $skill)
                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-3 py-1 text-sm">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>{{ $skill }}
                            </span>
                        @empty
                            <p class="text-gray-500">No skills listed.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="projects" class="py-10 sm:py-12 border-t border-gray-200 dark:border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between gap-4">
                        <h2 class="text-xl sm:text-2xl font-semibold">Projects</h2>
                        <a href="#projects" class="text-sm text-gray-500 hover:text-primary-600 dark:hover:text-primary-400">({{ count($get('projects', [])) }})</a>
                    </div>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($get('projects', []) as $project)
                            <article class="group rounded-2xl ring-1 ring-gray-200 dark:ring-gray-800 bg-white dark:bg-gray-900 overflow-hidden hover:shadow-lg transition">
                                <div class="aspect-[16/9] bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    @if(!empty($project['image_path']))
                                        <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project image' }}" class="h-full w-full object-cover" />
                                    @else
                                        <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3 class="font-semibold text-lg leading-snug">
                                        {{ $project['title'] ?? $project['name'] ?? 'Untitled Project' }}
                                    </h3>
                                    @if(!empty($project['description']))
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $project['description'] }}</p>
                                    @endif
                                    <div class="mt-4 flex items-center justify-between">
                                        @if(!empty($project['url']))
                                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                                <i data-lucide="external-link" class="w-4 h-4"></i> Visit
                                            </a>
                                        @endif
                                        <div class="text-xs text-gray-400">#{{ Str::limit($project['id'] ?? '', 8, '') }}</div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-gray-500">No projects to display.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="experience" class="py-10 sm:py-12 border-t border-gray-200 dark:border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl sm:text-2xl font-semibold">Experience</h2>
                    <div class="mt-6 space-y-4">
                        @forelse($get('experiences', []) as $exp)
                            <article class="p-5 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-800 bg-white dark:bg-gray-900">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-lg">{{ $exp['title'] ?? 'Role' }}</h3>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <span class="font-medium">{{ $exp['company'] ?? 'Company' }}</span>
                                            @if(!empty($exp['location']))
                                                <span class="mx-2">•</span><span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i>{{ $exp['location'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <i data-lucide="calendar" class="w-3 h-3 me-1 inline-block"></i>
                                        {{ $fmtDate($exp['start_date'] ?? null) }} — {{ $fmtDate($exp['end_date'] ?? null, 'Present') }}
                                    </div>
                                </div>
                                @if(!empty($exp['description']))
                                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $exp['description'] }}</p>
                                @endif
                            </article>
                        @empty
                            <p class="text-gray-500">No professional experience listed.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="education" class="py-10 sm:py-12 border-t border-gray-200 dark:border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl sm:text-2xl font-semibold">Education</h2>
                    <div class="mt-6 space-y-4">
                        @forelse($get('education', []) as $edu)
                            <article class="p-5 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-800 bg-white dark:bg-gray-900">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-lg">{{ $edu['school'] ?? 'School' }}</h3>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            @if(!empty($edu['degree']))<span>{{ $edu['degree'] }}</span>@endif
                                            @if(!empty($edu['field_of_study']))<span class="mx-2">•</span><span>{{ $edu['field_of_study'] }}</span>@endif
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <i data-lucide="calendar" class="w-3 h-3 me-1 inline-block"></i>
                                        {{ $fmtDate($edu['start_date'] ?? null) }} — {{ $fmtDate($edu['end_date'] ?? null) }}
                                    </div>
                                </div>
                                @if(!empty($edu['description']))
                                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $edu['description'] }}</p>
                                @endif
                            </article>
                        @empty
                            <p class="text-gray-500">No education details available.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>

        <footer class="mt-10 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex items-center justify-between text-sm text-gray-500">
                <p>Powered by <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://getmy.name" target="_blank" rel="noopener">getmy.name</a> from <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://mtex.dev" target="_blank" rel="noopener">mtex.dev</a></p>
                @if($get('api_request_count'))
                    <p class="hidden sm:block">API requests: {{ number_format($get('api_request_count')) }}</p>
                @endif
            </div>
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const current = localStorage.getItem('theme') || 'system';
            document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                btn.classList.toggle('ring-2', btn.dataset.themeBtn === current);
                btn.classList.toggle('ring-primary-500', btn.dataset.themeBtn === current);
            });
        });
    </script>
</body>
</html>