@php
    $get = fn($key, $default = null) => data_get($data, $key, $default);

    $fmtDate = function ($date, $fallback = 'Present') {
        if (empty($date)) return $fallback;
        try {
            return \Carbon\Carbon::parse($date)->format('M Y');
        } catch (\Throwable $e) {
            return $fallback;
        }
    };

    $socialMap = [
        'github' => ['bi-github', fn($v) => str_starts_with($v, 'http') ? $v : 'https://github.com/' . ltrim($v, '@')],
        'linkedin' => ['bi-linkedin', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.linkedin.com/in/' . ltrim($v, '@')],
        'twitter' => ['bi-twitter-x', fn($v) => str_starts_with($v, 'http') ? $v : 'https://x.com/' . ltrim($v, '@')],
        'bluesky' => ['bi-clouds-fill', fn($v) => str_starts_with($v, 'http') ? $v : 'https://bsky.app/profile/' . ltrim($v, '@')],
        'personal_website' => ['bi-globe2', fn($v) => $v],
        'codepen' => ['bi-box-seam', fn($v) => str_starts_with($v, 'http') ? $v : 'https://codepen.io/' . ltrim($v, '@')],
        'instagram' => ['bi-instagram', fn($v) => str_starts_with($v, 'http') ? $v : 'https://instagram.com/' . ltrim($v, '@')],
        'youtube_url' => ['bi-youtube', fn($v) => $v],
        'stackoverflow' => ['bi-stack-overflow', fn($v) => str_starts_with($v, 'http') ? $v : 'https://stackoverflow.com/users/' . ltrim($v, '@')],
        'dev_to' => ['bi-code-square', fn($v) => str_starts_with($v, 'http') ? $v : 'https://dev.to/' . ltrim($v, '@')],
        'hashnode' => ['bi-journal-code', fn($v) => str_starts_with($v, 'http') ? $v : 'https://hashnode.com/@' . ltrim($v, '@')],
        'npm' => ['bi-box2-fill', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.npmjs.com/~' . ltrim($v, '@')],
        'product_hunt' => ['bi-p-circle', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.producthunt.com/@' . ltrim($v, '@')],
        'polywork' => ['bi-person-badge', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.polywork.com/' . ltrim($v, '@')],
        'gitlab' => ['bi-gitlab', fn($v) => str_starts_with($v, 'http') ? $v : 'https://gitlab.com/' . ltrim($v, '@')],
        'dribbble' => ['bi-dribbble', fn($v) => str_starts_with($v, 'http') ? $v : 'https://dribbble.com/' . ltrim($v, '@')],
        'figma' => ['bi-figma', fn($v) => str_starts_with($v, 'http') ? $v : 'https://www.figma.com/@' . ltrim($v, '@')],
    ];

    $title = $get('name', 'Developer') . ' — Portfolio';
    $img = $get('avatar_url');
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>
    <meta name="description" content="{{ Str::limit($get('bio'), 160) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-300 antialiased selection:bg-emerald-500/30 selection:text-emerald-200">
    
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-emerald-900/10 blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-900/10 blur-[100px]"></div>
    </div>

    <div class="relative z-10 flex min-h-screen flex-col">
        
        <header class="fixed top-0 w-full z-50 border-b border-white/5 bg-slate-950/80 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <a href="#" class="text-xl font-heading font-bold text-white tracking-tight flex items-center gap-2">
                    <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                    {{ $get('username', 'portfolio') }}
                </a>
                
                <div class="flex items-center gap-6">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-sm font-medium hover:text-white transition-colors">
                                <img src="{{ Auth::user()->avatar() }}" class="w-8 h-8 rounded-full ring-2 ring-slate-800" />
                            </button>
                            <div class="absolute right-0 mt-2 w-48 py-2 bg-slate-900 border border-slate-800 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-slate-800 hover:text-white">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-slate-800">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-1 pt-32 pb-20">
            <section class="max-w-7xl mx-auto px-6 mb-24">
                <div class="grid lg:grid-cols-[1fr,400px] gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-emerald-400 text-xs font-medium uppercase tracking-wider mb-6">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            Available for work
                        </div>
                        
                        <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight mb-6 font-heading">
                            Hi, I'm <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-500">{{ $get('name') }}</span>.
                        </h1>
                        
                        <p class="text-xl text-slate-400 max-w-2xl leading-relaxed mb-8">
                            {{ $get('bio') }}
                        </p>

                        <div class="flex flex-wrap gap-3">
                            @if($get('email'))
                                <a href="mailto:{{ $get('email') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-white text-slate-950 font-semibold hover:bg-emerald-400 transition-colors">
                                    Contact Me
                                </a>
                            @endif
                            <a href="#projects" class="inline-flex items-center justify-center px-6 py-3 rounded-lg border border-slate-800 text-white font-medium hover:bg-slate-800 transition-colors">
                                View Projects
                            </a>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2 flex justify-center lg:justify-end">
                        <div class="relative w-64 h-64 md:w-80 md:h-80 group">
                            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500 to-indigo-500 rounded-[2rem] rotate-6 opacity-50 blur-lg group-hover:rotate-12 transition-transform duration-500"></div>
                            <img src="{{ $img }}" alt="{{ $get('name') }}" class="relative w-full h-full object-cover rounded-[2rem] ring-4 ring-slate-950 shadow-2xl grayscale group-hover:grayscale-0 transition-all duration-500" />
                        </div>
                    </div>
                </div>
            </section>

            <section class="max-w-7xl mx-auto px-6 mb-24">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border-y border-white/5 py-8">
                    @if($get('location'))
                        <div class="text-center md:text-left">
                            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Based In</div>
                            <div class="text-white font-medium">{{ $get('location') }}</div>
                        </div>
                    @endif
                    <div class="text-center md:text-left">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Experience</div>
                        <div class="text-white font-medium">{{ count($get('experiences', [])) }} Roles</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Projects</div>
                        <div class="text-white font-medium">{{ count($get('projects', [])) }} Shipped</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Stack</div>
                        <div class="text-white font-medium">{{ count($get('skills', [])) }} Technologies</div>
                    </div>
                </div>
            </section>

            @if($get('about_me'))
                <section class="max-w-7xl mx-auto px-6 mb-24">
                    <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                        <i class="bi bi-person-circle text-emerald-500"></i> About
                    </h2>
                    <div class="prose prose-invert prose-lg max-w-none text-slate-400">
                        <p>{{ $get('about_me') }}</p>
                    </div>
                </section>
            @endif

            <section class="max-w-7xl mx-auto px-6 mb-24">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="bi bi-cpu text-emerald-500"></i> Skills
                    </h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($get('skills', []) as $skill)
                        <span class="px-4 py-2 rounded-md bg-slate-900 border border-slate-800 text-slate-300 text-sm font-medium hover:border-emerald-500/50 hover:text-emerald-400 transition-colors cursor-default">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </section>

            <section id="projects" class="max-w-7xl mx-auto px-6 mb-24">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="bi bi-code-square text-emerald-500"></i> Selected Projects
                    </h2>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($get('projects', []) as $project)
                        <a href="{{ $project['url'] ?: '#' }}" target="_blank" class="group block h-full bg-slate-900/50 border border-slate-800 rounded-2xl overflow-hidden hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
                            <div class="aspect-video w-full overflow-hidden bg-slate-900 relative">
                                @if($project['image_path'])
                                    <img src="{{ $project['image_path'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $project['title'] }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-700">
                                        <i class="bi bi-terminal text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent opacity-60"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors font-heading">
                                    {{ $project['title'] ?? $project['name'] }}
                                </h3>
                                <p class="text-slate-400 text-sm line-clamp-2 mb-4">
                                    {{ $project['description'] }}
                                </p>
                                <div class="flex items-center text-xs font-mono text-slate-500 gap-2">
                                    <span>ID: {{ substr($project['id'], 0, 8) }}</span>
                                    @if($project['url'])
                                        <span class="ml-auto text-emerald-500 group-hover:underline">Visit -></span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="max-w-7xl mx-auto px-6 mb-24">
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                            <i class="bi bi-briefcase text-emerald-500"></i> Experience
                        </h2>
                        <div class="space-y-8 border-l border-slate-800 ml-3 pl-8 relative">
                            @foreach($get('experiences', []) as $exp)
                                <div class="relative">
                                    <span class="absolute -left-[41px] top-1 h-5 w-5 rounded-full border-4 border-slate-950 bg-slate-700"></span>
                                    <div class="mb-1 text-sm text-emerald-400 font-mono">
                                        {{ $fmtDate($exp['start_date']) }} — {{ $fmtDate($exp['end_date']) }}
                                    </div>
                                    <h3 class="text-lg font-bold text-white">{{ $exp['title'] }}</h3>
                                    <div class="text-slate-400 mb-2">{{ $exp['company'] }} @if($exp['location']) &middot; {{ $exp['location'] }} @endif</div>
                                    @if($exp['description'])
                                        <p class="text-sm text-slate-500 leading-relaxed">{{ $exp['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                            <i class="bi bi-mortarboard text-emerald-500"></i> Education
                        </h2>
                        <div class="space-y-6">
                            @foreach($get('education', []) as $edu)
                                <div class="p-6 rounded-2xl bg-slate-900/50 border border-slate-800">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-bold text-white">{{ $edu['school'] }}</h3>
                                        <span class="text-xs text-slate-500 font-mono bg-slate-950 px-2 py-1 rounded">
                                            {{ $fmtDate($edu['start_date']) }} - {{ $fmtDate($edu['end_date']) }}
                                        </span>
                                    </div>
                                    <div class="text-emerald-400 text-sm mb-2">{{ $edu['degree'] }}</div>
                                    @if($edu['description'])
                                        <p class="text-sm text-slate-500">{{ $edu['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-white/5 bg-slate-950 pt-16 pb-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col items-center justify-center mb-12">
                    <h3 class="text-2xl font-bold text-white mb-8">Connect With Me</h3>
                    <div class="flex flex-wrap justify-center gap-4 max-w-3xl">
                        @foreach($socialMap as $key => [$icon, $builder])
                            @if($val = $get('socials.'.$key))
                                <a href="{{ $builder($val) }}" target="_blank" class="flex items-center justify-center w-12 h-12 rounded-full bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:border-emerald-500/50 hover:bg-emerald-500/10 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/20" title="{{ ucfirst(str_replace('_', ' ', $key)) }}">
                                    <i class="bi {{ $icon }} text-xl"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-600 border-t border-white/5 pt-8">
                    <p>&copy; {{ date('Y') }} {{ $get('name') }}. All rights reserved.</p>
                    <div class="flex items-center gap-6">
                        @if($count = $get('api_request_count'))
                            <span class="font-mono text-xs px-2 py-1 rounded bg-slate-900 text-slate-500">
                                API::{{ number_format($count) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>