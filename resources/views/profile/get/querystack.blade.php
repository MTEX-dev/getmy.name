@php
    $user = $data;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user['name'] }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-green-400 font-mono min-h-screen">
    
    <!-- Header Section -->
    <header class="border-b-2 border-green-500/30 bg-slate-900/50 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-start gap-6">
                <!-- Avatar -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-green-500/20 blur-xl group-hover:bg-green-500/30 transition-all"></div>
                    <img src="{{ $user['avatar_url'] }}" 
                         alt="{{ $user['name'] }}" 
                         class="relative w-32 h-32 rounded-lg border-2 border-green-500/50 object-cover shadow-lg shadow-green-500/20">
                    <div class="absolute -bottom-2 -right-2 bg-slate-900 border-2 border-green-500 rounded px-2 py-1 text-xs">
                        <span class="text-green-400">ONLINE</span>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <div class="text-green-500/60 text-sm mb-1">
                        <span class="text-cyan-400">mysql></span> SELECT * FROM users WHERE username = '{{ $user['username'] }}';
                    </div>
                    <h1 class="text-4xl font-bold text-green-300 mb-2 tracking-tight">{{ $user['name'] }}</h1>
                    @if($user['title'])
                        <p class="text-xl text-green-400/80 mb-2">{{ $user['title'] }}</p>
                    @endif
                    @if($user['location'])
                        <p class="text-green-500/60 flex items-center gap-2">
                            <span class="text-cyan-400">→</span> {{ $user['location'] }}
                        </p>
                    @endif
                    @if($user['bio'])
                        <p class="mt-4 text-green-300/90 text-lg leading-relaxed max-w-3xl">{{ $user['bio'] }}</p>
                    @endif

                    <!-- Social Links -->
                    @if($user['socials'] && count(array_filter($user['socials'])) > 0)
                        <div class="mt-4 flex gap-3">
                            @if(!empty($user['socials']['github']))
                                <a href="{{ $user['socials']['github'] }}" 
                                   target="_blank"
                                   class="px-4 py-2 bg-slate-800 border border-green-500/30 rounded hover:border-green-500 hover:bg-slate-800/80 transition-all text-sm">
                                    GitHub
                                </a>
                            @endif
                            @if(!empty($user['socials']['linkedin']))
                                <a href="{{ $user['socials']['linkedin'] }}" 
                                   target="_blank"
                                   class="px-4 py-2 bg-slate-800 border border-green-500/30 rounded hover:border-green-500 hover:bg-slate-800/80 transition-all text-sm">
                                    LinkedIn
                                </a>
                            @endif
                            @if(!empty($user['socials']['twitter']))
                                <a href="{{ $user['socials']['twitter'] }}" 
                                   target="_blank"
                                   class="px-4 py-2 bg-slate-800 border border-green-500/30 rounded hover:border-green-500 hover:bg-slate-800/80 transition-all text-sm">
                                    Twitter
                                </a>
                            @endif
                            @if(!empty($user['socials']['personal_website']))
                                <a href="{{ $user['socials']['personal_website'] }}" 
                                   target="_blank"
                                   class="px-4 py-2 bg-slate-800 border border-green-500/30 rounded hover:border-green-500 hover:bg-slate-800/80 transition-all text-sm">
                                    Website
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8 space-y-8">

        <!-- About Me -->
        @if($user['about_me'])
            <section class="bg-slate-900/30 border border-green-500/20 rounded-lg overflow-hidden">
                <div class="bg-slate-900/50 px-4 py-3 border-b border-green-500/20">
                    <h2 class="text-green-400 flex items-center gap-2">
                        <span class="text-cyan-400">mysql></span>
                        <span class="text-green-300">SELECT about_me FROM users;</span>
                        <span class="ml-auto text-green-500/50 text-xs">{{ count(explode(' ', $user['about_me'])) }} words</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-invert prose-green max-w-none">
                        <p class="text-green-300/90 leading-relaxed whitespace-pre-wrap">{{ $user['about_me'] }}</p>
                    </div>
                </div>
            </section>
        @endif

        <!-- Skills -->
        @if(!empty($user['skills']))
            <section class="bg-slate-900/30 border border-green-500/20 rounded-lg overflow-hidden">
                <div class="bg-slate-900/50 px-4 py-3 border-b border-green-500/20">
                    <h2 class="text-green-400 flex items-center gap-2">
                        <span class="text-cyan-400">mysql></span>
                        <span class="text-green-300">SELECT * FROM skills;</span>
                        <span class="ml-auto text-green-500/50 text-xs">{{ count($user['skills']) }} rows</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($user['skills'] as $skill)
                            <span class="px-4 py-2 bg-slate-800/50 border border-green-500/30 rounded text-green-300 hover:border-green-500 hover:bg-slate-800 transition-all">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Projects -->
        @if(!empty($user['projects']))
            <section class="bg-slate-900/30 border border-green-500/20 rounded-lg overflow-hidden">
                <div class="bg-slate-900/50 px-4 py-3 border-b border-green-500/20">
                    <h2 class="text-green-400 flex items-center gap-2">
                        <span class="text-cyan-400">mysql></span>
                        <span class="text-green-300">SELECT * FROM projects;</span>
                        <span class="ml-auto text-green-500/50 text-xs">{{ count($user['projects']) }} rows</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($user['projects'] as $project)
                            <div class="bg-slate-900/50 border border-green-500/20 rounded-lg overflow-hidden hover:border-green-500/50 transition-all group">
                                @if($project['image_path'])
                                    <div class="h-48 overflow-hidden bg-slate-800/50">
                                        <img src="{{ $project['image_path'] }}" 
                                             alt="{{ $project['title'] }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-xl font-bold text-green-300 mb-2">{{ $project['title'] }}</h3>
                                    @if($project['description'])
                                        <p class="text-green-400/70 mb-4 line-clamp-3">{{ $project['description'] }}</p>
                                    @endif
                                    @if($project['url'])
                                        <a href="{{ $project['url'] }}" 
                                           target="_blank"
                                           class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition-colors">
                                            <span>View Project</span>
                                            <span>→</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Experience -->
        @if(!empty($user['experiences']))
            <section class="bg-slate-900/30 border border-green-500/20 rounded-lg overflow-hidden">
                <div class="bg-slate-900/50 px-4 py-3 border-b border-green-500/20">
                    <h2 class="text-green-400 flex items-center gap-2">
                        <span class="text-cyan-400">mysql></span>
                        <span class="text-green-300">SELECT * FROM experiences ORDER BY start_date DESC;</span>
                        <span class="ml-auto text-green-500/50 text-xs">{{ count($user['experiences']) }} rows</span>
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    @foreach($user['experiences'] as $experience)
                        <div class="border-l-2 border-green-500/30 pl-6 hover:border-green-500 transition-colors">
                            <h3 class="text-xl font-bold text-green-300">{{ $experience['title'] }}</h3>
                            <p class="text-green-400/80 mb-2">{{ $experience['company'] }}</p>
                            <p class="text-green-500/60 text-sm mb-3">
                                {{ $experience['start_date'] }} - {{ $experience['end_date'] ?? 'Present' }}
                                @if($experience['location'])
                                    <span class="mx-2">•</span>{{ $experience['location'] }}
                                @endif
                            </p>
                            @if($experience['description'])
                                <p class="text-green-300/80 leading-relaxed">{{ $experience['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Education -->
        @if(!empty($user['education']))
            <section class="bg-slate-900/30 border border-green-500/20 rounded-lg overflow-hidden">
                <div class="bg-slate-900/50 px-4 py-3 border-b border-green-500/20">
                    <h2 class="text-green-400 flex items-center gap-2">
                        <span class="text-cyan-400">mysql></span>
                        <span class="text-green-300">SELECT * FROM education ORDER BY start_date DESC;</span>
                        <span class="ml-auto text-green-500/50 text-xs">{{ count($user['education']) }} rows</span>
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    @foreach($user['education'] as $edu)
                        <div class="border-l-2 border-green-500/30 pl-6 hover:border-green-500 transition-colors">
                            <h3 class="text-xl font-bold text-green-300">{{ $edu['school'] }}</h3>
                            <p class="text-green-400/80 mb-2">
                                {{ $edu['degree'] }}
                                @if($edu['field_of_study'])
                                    <span class="text-green-500/60">in {{ $edu['field_of_study'] }}</span>
                                @endif
                            </p>
                            <p class="text-green-500/60 text-sm mb-3">
                                {{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}
                            </p>
                            @if($edu['description'])
                                <p class="text-green-300/80 leading-relaxed">{{ $edu['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    <!-- Footer -->
    <footer class="border-t border-green-500/20 bg-slate-900/50 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between text-green-500/50 text-sm">
                <p>
                    <span class="text-cyan-400">mysql></span> 
                    Profile loaded successfully
                </p>
                @if(isset($user['api_request_count']))
                    <p>{{ $user['api_request_count'] }} API requests</p>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>