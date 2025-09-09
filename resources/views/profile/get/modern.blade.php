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
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">
    <div class="flex flex-col md:flex-row min-h-screen relative">
        <aside class="md:w-64 lg:w-72 xl:w-80 md:h-screen md:fixed md:top-0 md:left-0 bg-white dark:bg-gray-950 p-6 sm:p-8 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-800 overflow-y-auto">
            <div class="flex flex-col h-full">
                <div class="text-center">
                    <div class="mx-auto h-28 w-28 sm:h-32 sm:w-32 rounded-full overflow-hidden ring-2 ring-offset-4 ring-offset-white dark:ring-offset-gray-950 ring-primary-500 shadow-lg">
                        <img src="{{ $get('avatar_url') }}" alt="{{ $get('name') }} avatar" class="h-full w-full object-cover" />
                    </div>
                    <h1 class="mt-6 text-2xl sm:text-3xl font-bold tracking-tight">{{ $get('name') }}</h1>
                    <p class="mt-2 text-lg text-primary-600 dark:text-primary-400 font-medium">{{ $get('title') }}</p>
                </div>

                <nav class="mt-8 flex-1">
                    <ul class="space-y-2">
                        <li><a href="#about" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><i class="bi bi-person-circle text-lg"></i> About</a></li>
                        <li><a href="#skills" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><i class="bi bi-tools text-lg"></i> Skills</a></li>
                        <li><a href="#projects" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><i class="bi bi-code-slash text-lg"></i> Projects</a></li>
                        <li><a href="#experience" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><i class="bi bi-briefcase-fill text-lg"></i> Experience</a></li>
                        <li><a href="#education" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><i class="bi bi-mortarboard-fill text-lg"></i> Education</a></li>
                    </ul>
                </nav>

                <div class="mt-8">
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        @foreach($socialMap as $key => [$label, $icon, $urlBuilder])
                            @php $val = $get('socials.' . $key); @endphp
                            @if(!empty($val))
                                @php $href = $urlBuilder($val); @endphp
                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-gray-200 dark:border-gray-800 text-xl hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition" title="{{ $label }}">
                                    <i class="bi {{ $icon }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>Powered by <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://getmy.name" target="_blank" rel="noopener">getmy.name</a></p>
                </div>
            </div>
        </aside>

        <main id="top" class="flex-1 md:ml-64 lg:ml-72 xl:ml-80 scroll-mt-16">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
                @if($get('about_me'))
                    <section id="about" class="scroll-mt-20">
                        <h2 class="text-2xl sm:text-3xl font-semibold">About Me</h2>
                        <div class="mt-6 prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $get('about_me') }}</p>
                        </div>
                    </section>
                @endif

                <section id="skills" class="mt-12 scroll-mt-20">
                    <h2 class="text-2xl sm:text-3xl font-semibold">Skills</h2>
                    <div class="mt-6 flex flex-wrap gap-3">
                        @forelse($get('skills', []) as $skill)
                            <span class="inline-flex items-center gap-2 rounded-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-4 py-2 text-sm font-medium shadow-sm">
                                <i class="bi bi-patch-check-fill text-primary-500"></i>{{ $skill }}
                            </span>
                        @empty
                            <p class="text-gray-500">No skills listed.</p>
                        @endforelse
                    </div>
                </section>

                <section id="projects" class="mt-12 scroll-mt-20">
                    <h2 class="text-2xl sm:text-3xl font-semibold">Projects</h2>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-8">
                        @forelse($get('projects', []) as $project)
                            <article class="group rounded-2xl ring-1 ring-gray-200 dark:ring-gray-800 bg-white dark:bg-gray-950 overflow-hidden hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                                <div class="aspect-[16/9] bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    @if(!empty($project['image_path']))
                                        <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project image' }}" class="h-full w-full object-cover" />
                                    @else
                                        <i class="bi bi-card-image text-4xl text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="font-semibold text-xl leading-snug">
                                        {{ $project['title'] ?? $project['name'] ?? 'Untitled Project' }}
                                    </h3>
                                    @if(!empty($project['description']))
                                        <p class="mt-3 text-gray-600 dark:text-gray-300">{{ $project['description'] }}</p>
                                    @endif
                                    @if(!empty($project['url']))
                                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-primary-600 dark:text-primary-400 group-hover:underline">
                                            Visit Project <i class="bi bi-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <p class="text-gray-500">No projects to display.</p>
                        @endforelse
                    </div>
                </section>

                <section id="experience" class="mt-12 scroll-mt-20">
                    <h2 class="text-2xl sm:text-3xl font-semibold">Experience</h2>
                    <div class="mt-6 border-l-2 border-primary-500 pl-6 space-y-8">
                        @forelse($get('experiences', []) as $exp)
                            <article class="relative">
                                <div class="absolute -left-[34px] top-1 h-4 w-4 rounded-full bg-primary-500 ring-4 ring-white dark:ring-gray-900"></div>
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-xl">{{ $exp['title'] ?? 'Role' }}</h3>
                                        <div class="text-gray-600 dark:text-gray-300">
                                            <span class="font-medium">{{ $exp['company'] ?? 'Company' }}</span>
                                            @if(!empty($exp['location']))
                                                <span class="mx-2">•</span><span>{{ $exp['location'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $fmtDate($exp['start_date'] ?? null) }} — {{ $fmtDate($exp['end_date'] ?? null, 'Present') }}
                                    </div>
                                </div>
                                @if(!empty($exp['description']))
                                    <p class="mt-3 text-gray-600 dark:text-gray-300">{{ $exp['description'] }}</p>
                                @endif
                            </article>
                        @empty
                            <p class="text-gray-500">No professional experience listed.</p>
                        @endforelse
                    </div>
                </section>

                <section id="education" class="mt-12 scroll-mt-20">
                    <h2 class="text-2xl sm:text-3xl font-semibold">Education</h2>
                    <div class="mt-6 space-y-6">
                        @forelse($get('education', []) as $edu)
                            <article class="p-6 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-800 bg-white dark:bg-gray-950">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-xl">{{ $edu['school'] ?? 'School' }}</h3>
                                        <div class="text-gray-600 dark:text-gray-300">
                                            @if(!empty($edu['degree']))<span>{{ $edu['degree'] }}</span>@endif
                                            @if(!empty($edu['field_of_study']))<span class="mx-2">•</span><span>{{ $edu['field_of_study'] }}</span>@endif
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $fmtDate($edu['start_date'] ?? null) }} — {{ $fmtDate($edu['end_date'] ?? null) }}
                                    </div>
                                </div>
                                @if(!empty($edu['description']))
                                    <p class="mt-3 text-gray-600 dark:text-gray-300">{{ $edu['description'] }}</p>
                                @endif
                            </article>
                        @empty
                            <p class="text-gray-500">No education details available.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>