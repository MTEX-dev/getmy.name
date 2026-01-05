@php
    $get = fn($key, $default = null) => data_get($data, $key, $default);

    $fmtDate = function ($date, $fallback = '—') {
        if (empty($date)) return $fallback;
        try {
            $year = (int) substr($date, 0, 4);
            if ($year < 1900 || $year > 2100) return $fallback;
            return \Carbon\Carbon::parse($date)->isoFormat('MMM YYYY');
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
        'bluesky' => [
            'Bluesky', 'bi-clouds', fn($v) => str_starts_with($v, 'http') ? $v : 'https://bsky.app/profile/' . ltrim($v, '@'),
        ],
        'personal_website' => [
            'Website', 'bi-globe2', function ($v) { return $v; }
        ],
        'codepen' => [
            'CodePen', 'bi-code-square', fn($v) => str_starts_with($v, 'http') ? $v : 'https://codepen.io/' . ltrim($v, '@'),
        ],
        'instagram' => [
            'Instagram', 'bi-instagram', fn($v) => str_starts_with($v, 'http') ? $v : 'https://instagram.com/' . ltrim($v, '@'),
        ],
        'youtube_url' => [
            'YouTube', 'bi-youtube', fn($v) => str_starts_with($v, 'http') ? $v : 'https://youtube.com/@' . ltrim($v, '@'),
        ],
        'stackoverflow' => [
            'Stack Overflow', 'bi-stack-overflow', fn($v) => str_starts_with($v, 'http') ? $v : 'https://stackoverflow.com/users/' . $v,
        ],
        'npm' => [
            'NPM', 'bi-box-seam', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.npmjs.com/~' . ltrim($v, '@'),
        ],
        'dev_to' => [
            'Dev.to', 'bi-terminal', fn($v) => str_starts_with($v, 'http') ? $v : 'https://dev.to/' . ltrim($v, '@'),
        ],
        'hashnode' => [
            'Hashnode', 'bi-journal-text', fn($v) => str_starts_with($v, 'http') ? $v : 'https://hashnode.com/@' . ltrim($v, '@'),
        ],
        'product_hunt' => [
            'Product Hunt', 'bi-rocket-takeoff', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.producthunt.com/@' . ltrim($v, '@'),
        ],
        'polywork' => [
            'Polywork', 'bi-grid-3x3-gap', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.polywork.com/' . ltrim($v, '@'),
        ],
        'gitlab' => [
            'GitLab', 'bi-gitlab', fn($v) => str_starts_with($v, 'http') ? $v : 'https://gitlab.com/' . ltrim($v, '@'),
        ],
        'dribbble' => [
            'Dribbble', 'bi-dribbble', fn($v) => str_starts_with($v, 'http') ? $v : 'https://dribbble.com/' . ltrim($v, '@'),
        ],
        'figma' => [
            'Figma', 'bi-figma', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.figma.com/@' . ltrim($v, '@'),
        ],
    ];

    $title = $get('name', 'Developer') . ' — Portfolio';
    $description = Str::limit($get('bio', 'Developer portfolio.'), 160);
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
                    btn.classList.toggle('bg-gray-900', btn.dataset.themeBtn === mode);
                    btn.classList.toggle('dark:bg-gray-100', btn.dataset.themeBtn === mode);
                    btn.classList.toggle('text-white', btn.dataset.themeBtn === mode);
                    btn.classList.toggle('dark:text-gray-900', btn.dataset.themeBtn === mode);
                });
            };
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const current = localStorage.getItem('theme') || 'system';
                if (current === 'system') applyTheme('system');
            });
        })();
    </script>
</head>
<body class="bg-gray-50 text-gray-950 dark:bg-black dark:text-white antialiased font-mono">
    <div class="min-h-screen">
        <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-50/80 dark:bg-black/80 backdrop-blur-md border-b border-gray-900 dark:border-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 h-14 flex items-center justify-between">
                <a href="#top" class="text-sm font-bold uppercase tracking-wider hover:text-blue-600 dark:hover:text-blue-400 transition">
                    {{ $get('username', 'Portfolio') }}
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm hover:text-blue-600 dark:hover:text-blue-400 transition">
                                <img src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}" class="h-6 w-6 rounded-full border border-gray-900 dark:border-white" />
                                <i class="bi bi-chevron-down text-xs" :class="open && 'rotate-180'"></i>
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-900 border border-gray-900 dark:border-white shadow-lg" style="display: none;">
                                <div class="border-b border-gray-200 dark:border-gray-800 p-3">
                                    <p class="text-xs font-bold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="p-1">
                                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-xs hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-xs hover:bg-gray-100 dark:hover:bg-gray-800">Dashboard</a>
                                    <a href="{{ route('profile.preview') }}" class="block px-3 py-2 text-xs hover:bg-gray-100 dark:hover:bg-gray-800">Preview</a>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-800 p-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-3 py-2 text-xs text-red-600 hover:bg-gray-100 dark:hover:bg-gray-800">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                    <div class="flex gap-1 border border-gray-900 dark:border-white">
                        <button data-theme-btn="light" onclick="__setTheme('light')" class="px-2 py-1 text-xs hover:bg-gray-900 hover:text-white dark:hover:bg-gray-100 dark:hover:text-gray-900 transition" title="Light">
                            <i class="bi bi-sun-fill"></i>
                        </button>
                        <button data-theme-btn="dark" onclick="__setTheme('dark')" class="px-2 py-1 text-xs hover:bg-gray-900 hover:text-white dark:hover:bg-gray-100 dark:hover:text-gray-900 transition" title="Dark">
                            <i class="bi bi-moon-fill"></i>
                        </button>
                        <button data-theme-btn="system" onclick="__setTheme('system')" class="px-2 py-1 text-xs hover:bg-gray-900 hover:text-white dark:hover:bg-gray-100 dark:hover:text-gray-900 transition" title="System">
                            <i class="bi bi-laptop"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main id="top" class="pt-14">
            <section class="border-b border-gray-900 dark:border-white py-16 lg:py-24">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="grid lg:grid-cols-[200px,1fr] gap-12 items-start">
                        <div class="w-48 h-48 lg:w-full lg:h-auto aspect-square border-4 border-gray-900 dark:border-white overflow-hidden">
                            <img src="{{ $get('avatar_url') }}" alt="{{ $get('name') }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-500" />
                        </div>
                        <div>
                            <h1 class="text-4xl lg:text-6xl font-bold uppercase tracking-tight leading-none">{{ $get('name') }}</h1>
                            <p class="mt-3 text-xl lg:text-2xl text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wide">{{ $get('title') }}</p>
                            <p class="mt-6 text-sm lg:text-base leading-relaxed max-w-3xl">{{ $get('bio') }}</p>
                            <div class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-xs uppercase tracking-wider">
                                @if($get('location'))
                                    <span class="flex items-center gap-1.5">
                                        <i class="bi bi-geo-alt-fill"></i>{{ $get('location') }}
                                    </span>
                                @endif
                                @if($get('email'))
                                    <a href="mailto:{{ $get('email') }}" class="flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400">
                                        <i class="bi bi-envelope-fill"></i>{{ $get('email') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-b border-gray-900 dark:border-white py-8">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="flex flex-wrap gap-2">
                        @foreach($socialMap as $key => [$label, $icon, $urlBuilder])
                            @php $val = $get('socials.' . $key); @endphp
                            @if(!empty($val))
                                <a href="{{ $urlBuilder($val) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-2 text-xs uppercase tracking-wider border border-gray-900 dark:border-white hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900 transition">
                                    <i class="bi {{ $icon }}"></i>{{ $label }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>

            @if($get('about_me'))
                <section class="border-b border-gray-900 dark:border-white py-16">
                    <div class="max-w-7xl mx-auto px-6 lg:px-12">
                        <h2 class="text-2xl font-bold uppercase tracking-wider mb-8">[About]</h2>
                        <div class="max-w-3xl text-sm lg:text-base leading-relaxed">
                            {{ $get('about_me') }}
                        </div>
                    </div>
                </section>
            @endif

            <section class="border-b border-gray-900 dark:border-white py-16">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <h2 class="text-2xl font-bold uppercase tracking-wider mb-8">[Skills] <span class="text-sm font-normal">({{ count($get('skills', [])) }})</span></h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($get('skills', []) as $skill)
                            <span class="px-3 py-1.5 text-xs uppercase tracking-wider border border-gray-900 dark:border-white">{{ $skill }}</span>
                        @empty
                            <p class="text-sm text-gray-500">No skills listed.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="border-b border-gray-900 dark:border-white py-16">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <h2 class="text-2xl font-bold uppercase tracking-wider mb-8">[Projects] <span class="text-sm font-normal">({{ count($get('projects', [])) }})</span></h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($get('projects', []) as $project)
                            <article class="border border-gray-900 dark:border-white group hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900 transition">
                                <div class="aspect-video bg-gray-200 dark:bg-gray-800 border-b border-gray-900 dark:border-white overflow-hidden">
                                    @if(!empty($project['image_path']))
                                        <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="bi bi-file-code text-4xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-bold uppercase tracking-wider">{{ $project['title'] ?? $project['name'] ?? 'Untitled' }}</h3>
                                    @if(!empty($project['description']))
                                        <p class="mt-2 text-xs leading-relaxed">{{ Str::limit($project['description'], 100) }}</p>
                                    @endif
                                    @if(!empty($project['url']))
                                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-xs uppercase tracking-wider hover:underline">
                                            View <i class="bi bi-arrow-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">No projects.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="border-b border-gray-900 dark:border-white py-16">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <h2 class="text-2xl font-bold uppercase tracking-wider mb-8">[Experience]</h2>
                    <div class="space-y-6">
                        @forelse($get('experiences', []) as $exp)
                            <article class="border-l-4 border-gray-900 dark:border-white pl-6">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h3 class="text-base font-bold uppercase tracking-wide">{{ $exp['title'] ?? 'Role' }}</h3>
                                    <span class="text-xs uppercase tracking-wider text-gray-500">
                                        {{ $fmtDate($exp['start_date'] ?? null) }} — {{ $fmtDate($exp['end_date'] ?? null, 'Present') }}
                                    </span>
                                </div>
                                <div class="text-xs uppercase tracking-wider mb-3">
                                    <span class="font-bold">{{ $exp['company'] ?? 'Company' }}</span>
                                    @if(!empty($exp['location']))
                                        <span class="mx-2">•</span>{{ $exp['location'] }}
                                    @endif
                                </div>
                                @if(!empty($exp['description']))
                                    <p class="text-sm leading-relaxed">{{ $exp['description'] }}</p>
                                @endif
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">No experience listed.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="border-b border-gray-900 dark:border-white py-16">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <h2 class="text-2xl font-bold uppercase tracking-wider mb-8">[Education]</h2>
                    <div class="space-y-6">
                        @forelse($get('education', []) as $edu)
                            <article class="border-l-4 border-gray-900 dark:border-white pl-6">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h3 class="text-base font-bold uppercase tracking-wide">{{ $edu['school'] ?? 'School' }}</h3>
                                    <span class="text-xs uppercase tracking-wider text-gray-500">
                                        {{ $fmtDate($edu['start_date'] ?? null) }} — {{ $fmtDate($edu['end_date'] ?? null) }}
                                    </span>
                                </div>
                                <div class="text-xs uppercase tracking-wider mb-3">
                                    @if(!empty($edu['degree'])){{ $edu['degree'] }}@endif
                                    @if(!empty($edu['field_of_study']))<span class="mx-2">•</span>{{ $edu['field_of_study'] }}@endif
                                </div>
                                @if(!empty($edu['description']))
                                    <p class="text-sm leading-relaxed">{{ $edu['description'] }}</p>
                                @endif
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">No education details.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>

        <footer class="py-8 border-t border-gray-900 dark:border-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-wrap items-center justify-between gap-4 text-xs uppercase tracking-wider">
                <div>
                    Powered by <a href="https://getmy.name" target="_blank" rel="noopener" class="font-bold hover:text-blue-600 dark:hover:text-blue-400">getmy.name</a> / <a href="https://mtex.dev" target="_blank" rel="noopener" class="font-bold hover:text-blue-600 dark:hover:text-blue-400">mtex.dev</a>
                </div>
                @if($get('api_request_count'))
                    <div class="text-gray-500">API: {{ number_format($get('api_request_count')) }}</div>
                @endif
            </div>
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const current = localStorage.getItem('theme') || 'system';
            document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                if (btn.dataset.themeBtn === current) {
                    btn.classList.add('bg-gray-900', 'dark:bg-gray-100', 'text-white', 'dark:text-gray-900');
                }
            });
        });
    </script>
</body>
</html>