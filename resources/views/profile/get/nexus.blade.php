@php
    $get = fn($key, $default = null) => data_get($data, $key, $default);
    
    $fmtDate = function ($date, $fallback = 'Present') {
        if (empty($date)) return $fallback;
        try {
            return \Carbon\Carbon::parse($date)->format('Y.m');
        } catch (\Throwable $e) {
            return $fallback;
        }
    };

    $socials = [
        'github' => ['icon' => 'bi-github', 'prefix' => 'https://github.com/'],
        'linkedin' => ['icon' => 'bi-linkedin', 'prefix' => 'https://linkedin.com/in/'],
        'twitter' => ['icon' => 'bi-twitter-x', 'prefix' => 'https://x.com/'],
        'bluesky' => ['icon' => 'bi-cloud', 'prefix' => 'https://bsky.app/profile/'],
        'personal_website' => ['icon' => 'bi-globe2', 'prefix' => ''],
        'codepen' => ['icon' => 'bi-code-slash', 'prefix' => 'https://codepen.io/'],
        'instagram' => ['icon' => 'bi-instagram', 'prefix' => 'https://instagram.com/'],
        'youtube_url' => ['icon' => 'bi-youtube', 'prefix' => ''],
        'stackoverflow' => ['icon' => 'bi-stack-overflow', 'prefix' => 'https://stackoverflow.com/users/'],
        'dev_to' => ['icon' => 'bi-terminal', 'prefix' => 'https://dev.to/'],
        'hashnode' => ['icon' => 'bi-pencil-square', 'prefix' => 'https://hashnode.com/@'],
        'npm' => ['icon' => 'bi-box-seam', 'prefix' => 'https://www.npmjs.com/~'],
        'product_hunt' => ['icon' => 'bi-trophy', 'prefix' => 'https://www.producthunt.com/@'],
        'polywork' => ['icon' => 'bi-briefcase', 'prefix' => 'https://www.polywork.com/'],
        'gitlab' => ['icon' => 'bi-gitlab', 'prefix' => 'https://gitlab.com/'],
        'dribbble' => ['icon' => 'bi-dribbble', 'prefix' => 'https://dribbble.com/'],
        'figma' => ['icon' => 'bi-figma', 'prefix' => 'https://www.figma.com/@'],
    ];

    $title = $get('name') . ' // TERMINAL';
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ Str::limit($get('bio'), 150) }}">
    <meta property="og:image" content="{{ $get('avatar_url') }}">
    <meta property="twitter:card" content="summary_large_image">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;600;700&display=swap');
        body { font-family: 'JetBrains Mono', monospace; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-300 antialiased selection:bg-emerald-500/30 selection:text-emerald-200">

    <div class="fixed inset-0 z-0 pointer-events-none opacity-5" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 min-h-screen flex flex-col lg:flex-row max-w-7xl mx-auto border-x border-zinc-800/50">
        
        <aside class="lg:w-[400px] lg:h-screen lg:sticky lg:top-0 border-b lg:border-b-0 lg:border-r border-zinc-800 flex flex-col bg-zinc-950/80 backdrop-blur-sm">
            <div class="p-8 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-8">
                    <div class="h-24 w-24 relative group">
                        <div class="absolute inset-0 bg-emerald-500/20 blur-xl rounded-full group-hover:bg-emerald-500/30 transition duration-500"></div>
                        <img src="{{ $get('avatar_url') }}" alt="Avatar" class="relative h-full w-full object-cover grayscale hover:grayscale-0 transition duration-300 border-2 border-zinc-800 rounded-sm">
                    </div>
                    
                    @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="text-zinc-500 hover:text-emerald-400 transition">
                            <i class="bi bi-gear-wide-connected text-xl"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-zinc-900 border border-zinc-700 shadow-xl z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-zinc-800 hover:text-emerald-400">Settings</a>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-zinc-800 hover:text-emerald-400">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-zinc-800">Disconnect</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>

                <h1 class="text-3xl font-bold text-white tracking-tighter">{{ $get('name') }}</h1>
                <p class="text-emerald-500 mt-1 font-semibold flex items-center gap-2">
                    <span class="animate-pulse w-2 h-2 bg-emerald-500 rounded-full"></span>
                    {{ $get('title') }}
                </p>

                <div class="mt-6 space-y-4 text-sm text-zinc-400">
                    <p class="leading-relaxed border-l-2 border-emerald-500/20 pl-4">{{ $get('bio') }}</p>
                    
                    <div class="flex flex-col gap-2 pt-4">
                        @if($get('location'))
                            <div class="flex items-center gap-3"><i class="bi bi-geo-alt-fill text-zinc-600"></i> {{ $get('location') }}</div>
                        @endif
                        @if($get('email'))
                            <a href="mailto:{{ $get('email') }}" class="flex items-center gap-3 hover:text-white transition"><i class="bi bi-envelope-fill text-zinc-600"></i> {{ $get('email') }}</a>
                        @endif
                    </div>
                </div>

                <div class="mt-auto pt-8 flex flex-wrap gap-4 pb-2">
                    @foreach($socials as $key => $meta)
                        @if($val = $get("socials.$key"))
                            <a 
                                href="{{ str_starts_with($val, 'http') ? $val : $meta['prefix'] . ltrim($val, '@') }}" 
                                target="_blank" 
                                class="h-10 w-10 flex items-center justify-center border border-zinc-700 hover:border-emerald-500 hover:bg-emerald-500/10 hover:text-emerald-400 transition text-lg group"
                            >
                                <i class="bi {{ $meta['icon'] }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            
            <div class="px-8 py-4 border-t border-zinc-800 text-xs text-zinc-600 flex justify-between uppercase tracking-widest">
                <span>SYS.READY</span>
                <span>{{ now()->format('H:i:s') }}</span>
            </div>
        </aside>

        <main class="flex-1 min-w-0">
            @if($get('about_me'))
            <section class="p-8 lg:p-12 border-b border-zinc-800/50">
                <h2 class="text-sm font-bold text-zinc-500 uppercase tracking-widest mb-6">:: /home/user/about</h2>
                <div class="prose prose-invert prose-p:text-zinc-400 prose-p:font-light max-w-none">
                    <p>{{ $get('about_me') }}</p>
                </div>
            </section>
            @endif

            <section class="p-8 lg:p-12 border-b border-zinc-800/50">
                <h2 class="text-sm font-bold text-zinc-500 uppercase tracking-widest mb-6">:: /bin/skills</h2>
                <div class="flex flex-wrap gap-2">
                    @forelse($get('skills', []) as $skill)
                        <span class="px-3 py-1 bg-zinc-900 border border-zinc-700 text-xs text-emerald-100 hover:border-emerald-500/50 transition cursor-default">
                            ./{{ Str::slug($skill) }}
                        </span>
                    @empty
                        <span class="text-zinc-600 text-sm">No modules loaded.</span>
                    @endforelse
                </div>
            </section>

            <section class="p-8 lg:p-12 border-b border-zinc-800/50">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-sm font-bold text-zinc-500 uppercase tracking-widest">:: /var/www/projects</h2>
                    <span class="text-xs px-2 py-0.5 bg-emerald-900/30 text-emerald-400 border border-emerald-900 rounded">{{ count($get('projects', [])) }} items</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($get('projects', []) as $project)
                        <a href="{{ $project['url'] ?: '#' }}" target="_blank" class="group relative bg-zinc-900/50 border border-zinc-800 hover:border-emerald-500/50 transition overflow-hidden block h-full">
                            <div class="aspect-video w-full bg-zinc-900 border-b border-zinc-800 overflow-hidden relative">
                                @if(!empty($project['image_path']))
                                    <img src="{{ $project['image_path'] }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition duration-500" alt="">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-zinc-700 font-mono text-4xl font-bold opacity-20">NULL</div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent opacity-80"></div>
                            </div>
                            <div class="p-4 relative">
                                <h3 class="font-bold text-white group-hover:text-emerald-400 transition">{{ $project['title'] ?? $project['name'] }}</h3>
                                <p class="text-xs text-zinc-500 mt-2 line-clamp-2">{{ $project['description'] }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs text-zinc-600 font-mono">id: {{ substr($project['id'], 0, 6) }}</span>
                                    <i class="bi bi-arrow-up-right text-zinc-600 group-hover:text-emerald-400"></i>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-8 text-center text-zinc-600 border border-dashed border-zinc-800">Directory empty.</div>
                    @endforelse
                </div>
            </section>

            <div class="grid lg:grid-cols-2">
                <section class="p-8 lg:p-12 border-b lg:border-b-0 lg:border-r border-zinc-800/50">
                    <h2 class="text-sm font-bold text-zinc-500 uppercase tracking-widest mb-6">:: /usr/jobs</h2>
                    <div class="relative border-l border-zinc-800 ml-2 space-y-8">
                        @forelse($get('experiences', []) as $exp)
                            <div class="pl-6 relative">
                                <div class="absolute -left-[5px] top-1.5 h-2.5 w-2.5 rounded-full bg-zinc-900 border border-zinc-600"></div>
                                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-1">
                                    <h3 class="text-emerald-400 font-semibold">{{ $exp['title'] }}</h3>
                                    <span class="text-xs font-mono text-zinc-500 whitespace-nowrap">{{ $fmtDate($exp['start_date']) }} - {{ $fmtDate($exp['end_date']) }}</span>
                                </div>
                                <div class="text-sm text-zinc-300 font-medium mb-2">{{ $exp['company'] }}</div>
                                <p class="text-xs text-zinc-500 leading-relaxed">{{ $exp['description'] }}</p>
                            </div>
                        @empty
                            <div class="pl-6 text-sm text-zinc-600">No logs found.</div>
                        @endforelse
                    </div>
                </section>

                <section class="p-8 lg:p-12 border-b border-zinc-800/50">
                    <h2 class="text-sm font-bold text-zinc-500 uppercase tracking-widest mb-6">:: /usr/edu</h2>
                    <div class="space-y-6">
                        @forelse($get('education', []) as $edu)
                            <div class="bg-zinc-900/30 p-4 border border-zinc-800">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-white font-medium">{{ $edu['school'] }}</h3>
                                    <span class="text-xs text-zinc-600 font-mono">{{ $fmtDate($edu['start_date']) }}</span>
                                </div>
                                <div class="text-sm text-zinc-400 mt-1">{{ $edu['degree'] }}</div>
                                @if($edu['field_of_study'])
                                    <div class="text-xs text-emerald-500/80 mt-1">&lt;{{ $edu['field_of_study'] }}&gt;</div>
                                @endif
                            </div>
                        @empty
                            <div class="text-sm text-zinc-600">No records.</div>
                        @endforelse
                    </div>
                </section>
            </div>
            
            <footer class="p-8 lg:p-12 text-xs text-zinc-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>{{ 'root@' . strtolower(str_replace(' ', '', $get('name'))) }}:~$ exit 0</div>
                @if($get('api_request_count'))
                    <div class="font-mono">REQ_COUNT: <span class="text-emerald-500">{{ $get('api_request_count') }}</span></div>
                @endif
            </footer>
        </main>
    </div>
</body>
</html>