@php
    /**
     * @var array $data
     */

    // Helper: safe accessor
    $get = fn($key, $default = null) => data_get($data, $key, $default);

    // Helper: date formatting with graceful fallback
    $fmtDate = function ($date, $fallback = '—') {
        if (empty($date)) return $fallback;
        try {
            // Guard against obviously invalid or extreme years
            $year = (int) substr($date, 0, 4);
            if ($year < 1900 || $year > 2100) return $fallback;
            return \Carbon\Carbon::parse($date)->isoFormat('MMM D, YYYY');
        } catch (\Throwable $e) {
            return $fallback;
        }
    };

    // Social links map: key => [label, icon, url builder]
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
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $get('name', 'Developer') }} — Portfolio</title>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <script>
        // Theme handling: dark/light/system using Tailwind's "class" strategy
        (function() {
            const applyTheme = (mode) => {
                const root = document.documentElement;
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const shouldDark = mode === 'dark' || (mode === 'system' && systemPrefersDark);
                root.classList.toggle('dark', shouldDark);
                root.dataset.theme = mode;
            };

            // Apply early to avoid FOUC
            const saved = localStorage.getItem('theme') || 'system';
            applyTheme(saved);

            // Expose for later toggles
            window.__setTheme = function(mode) {
                localStorage.setItem('theme', mode);
                applyTheme(mode);
                // Update active states
                document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                    btn.classList.toggle('ring-2', btn.dataset.themeBtn === mode);
                    btn.classList.toggle('ring-primary-500', btn.dataset.themeBtn === mode);
                });
            };

            // Listen to system changes if in system mode
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const current = localStorage.getItem('theme') || 'system';
                if (current === 'system') applyTheme('system');
            });
        })();
    </script>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Top Bar -->
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
                        <!-- Authenticated User Dropdown -->
                        <div x-data="{ open: false }" class="relative" x-cloak>
                            <button type="button" @click="open = !open" class="relative inline-flex items-center justify-center h-10 w-10 rounded-full ring-1 ring-gray-200 dark:ring-gray-800 hover:ring-primary-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 transition">
                                <span class="sr-only">Open user menu</span>
                                <img src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }} avatar" class="h-10 w-10 rounded-full object-cover" />
                            </button>
                            <div x-show="open" @click.outside="open = false" @keydown.escape.window="open = false" class="absolute right-0 mt-2 w-72 origin-top-right rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-2xl p-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }} avatar" class="h-12 w-12 rounded-xl object-cover ring-1 ring-gray-200 dark:ring-gray-800" />
                                    <div>
                                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                        @if(method_exists(Auth::user(), 'getAttribute'))
                                            @php $uname = Auth::user()->getAttribute('username') ?? (Auth::user()->username ?? null); @endphp
                                            @if($uname)
                                                <div class="text-xs text-gray-500">{{ '@'.$uname }}</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth

                    <!-- Theme Switcher -->
                    <div class="relative">
                        <div class="flex items-center gap-1 rounded-full border border-gray-200 dark:border-gray-800 p-1 bg-white dark:bg-gray-900 shadow-sm">
                            <button data-theme-btn="light" onclick="__setTheme('light')" class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="Light">
                                <i class="bi bi-sun"></i>
                            </button>
                            <button data-theme-btn="dark" onclick="__setTheme('dark')" class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="Dark">
                                <i class="bi bi-moon"></i>
                            </button>
                            <button data-theme-btn="system" onclick="__setTheme('system')" class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="System">
                                <i class="bi bi-circle-half"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main id="top" class="flex-1">
            <!-- Hero -->
            <section class="py-10 sm:py-12">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-[auto,1fr] items-center gap-8">
                        <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-2xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-800 shadow-md">
                            <img src="{{ $get('avatar_url') }}" alt="{{ $get('name') }} avatar" class="h-full w-full object-cover" />
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight">{{ $get('name') }}</h1>
                            <p class="mt-1 text-lg text-primary-600 dark:text-primary-400 font-medium">{{ $get('title') }}</p>
                            <p class="mt-4 max-w-3xl text-gray-600 dark:text-gray-300">{{ $get('bio') }}</p>
                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                @if($get('location'))
                                    <span class="inline-flex items-center gap-2"><i class="bi bi-geo-alt"></i>{{ $get('location') }}</span>
                                @endif
                                @if($get('email'))
                                    <a href="mailto:{{ $get('email') }}" class="inline-flex items-center gap-2 hover:text-primary-600 dark:hover:text-primary-400"><i class="bi bi-envelope"></i>{{ $get('email') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Social Links -->
            <section class="py-4">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap items-center gap-3">
                        @foreach($socialMap as $key => [$label, $icon, $urlBuilder])
                            @php $val = $get('socials.' . $key); @endphp
                            @if(!empty($val))
                                @php $href = $urlBuilder($val); @endphp
                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-gray-200 dark:border-gray-800 px-3 py-1.5 text-sm hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition">
                                    <i class="bi {{ $icon }} text-base"></i><span>{{ $label }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Skills -->
            <section id="skills" class="py-10 sm:py-12 border-t border-gray-200 dark:border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl sm:text-2xl font-semibold">Skills</h2>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @forelse($get('skills', []) as $skill)
                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-3 py-1 text-sm">
                                <i class="bi bi-check2-circle"></i>{{ $skill }}
                            </span>
                        @empty
                            <p class="text-gray-500">No skills listed.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Projects -->
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
                                        <i class="bi bi-card-image text-3xl text-gray-400"></i>
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
                                                <i class="bi bi-box-arrow-up-right"></i> Visit
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

            <!-- Experience -->
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
                                                <span class="mx-2">•</span><span class="inline-flex items-center gap-1"><i class="bi bi-geo"></i>{{ $exp['location'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <i class="bi bi-calendar3 me-1"></i>
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

            <!-- Education -->
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
                                        <i class="bi bi-calendar3 me-1"></i>
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

        <!-- Footer -->
        <footer class="mt-10 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex items-center justify-between text-sm text-gray-500">
                <p>Powered by <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://getmy.name" target="_blank" rel="noopener">getmy.name</a> from <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://mtex.dev" target="_blank" rel="noopener">mtex.dev</a></p>
                @if($get('api_request_count'))
                    <p class="hidden sm:block">API requests: {{ number_format($get('api_request_count')) }}</p>
                @endif
            </div>
        </footer>
    </div>

    <!-- Alpine.js for small interactivity (dropdown) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Initialize active ring on the theme buttons based on current theme
        document.addEventListener('DOMContentLoaded', () => {
            const current = localStorage.getItem('theme') || 'system';
            document.querySelectorAll('[data-theme-btn]')?.forEach(btn => {
                btn.classList.toggle('ring-2', btn.dataset.themeBtn === current);
                btn.classList.toggle('ring-primary-500', btn.dataset.themeBtn === current);
            });
        });
    </script>
</body>
</html>
