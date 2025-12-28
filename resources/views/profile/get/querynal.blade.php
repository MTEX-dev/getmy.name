<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] ?? 'Profile' }} - Developer Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-mono">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Header Section --}}
        <div class="mb-12 border-2 border-emerald-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-emerald-500/10 border-b border-emerald-500/30 px-6 py-3">
                <p class="text-emerald-400 text-sm">
                    <span class="text-emerald-300">SELECT</span> * 
                    <span class="text-emerald-300">FROM</span> users 
                    <span class="text-emerald-300">WHERE</span> username = <span class="text-amber-400">'{{ $data['username'] ?? '' }}'</span>;
                </p>
            </div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <img src="{{ $data['avatar_url'] ?? '' }}" 
                         alt="{{ $data['name'] ?? 'User' }}" 
                         class="w-32 h-32 rounded-lg border-2 border-emerald-500/50 shadow-lg shadow-emerald-500/20">
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold text-slate-100 mb-2">{{ $data['name'] ?? 'Unknown' }}</h1>
                        @if(!empty($data['title']))
                            <p class="text-xl text-emerald-400 mb-3">{{ $data['title'] }}</p>
                        @endif
                        @if(!empty($data['location']))
                            <p class="text-slate-400 mb-4">📍 {{ $data['location'] }}</p>
                        @endif
                        @if(!empty($data['bio']))
                            <p class="text-slate-300 leading-relaxed">{{ $data['bio'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Social Links --}}
        @if(!empty($data['socials']) && count(array_filter($data['socials'])) > 0)
        <div class="mb-12 border-2 border-cyan-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-cyan-500/10 border-b border-cyan-500/30 px-6 py-3">
                <p class="text-cyan-400 text-sm">
                    <span class="text-cyan-300">SELECT</span> * 
                    <span class="text-cyan-300">FROM</span> socials 
                    <span class="text-cyan-300">WHERE</span> user_id = <span class="text-amber-400">{{ $data['username'] ?? 'NULL' }}</span>;
                </p>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-4">
                    @if(!empty($data['socials']['github']))
                        <a href="{{ $data['socials']['github'] }}" 
                           target="_blank"
                           class="px-4 py-2 bg-slate-800 border border-slate-700 rounded hover:border-cyan-500/50 hover:bg-slate-800/80 transition-all">
                            🔗 GitHub
                        </a>
                    @endif
                    @if(!empty($data['socials']['linkedin']))
                        <a href="{{ $data['socials']['linkedin'] }}" 
                           target="_blank"
                           class="px-4 py-2 bg-slate-800 border border-slate-700 rounded hover:border-cyan-500/50 hover:bg-slate-800/80 transition-all">
                            🔗 LinkedIn
                        </a>
                    @endif
                    @if(!empty($data['socials']['twitter']))
                        <a href="{{ $data['socials']['twitter'] }}" 
                           target="_blank"
                           class="px-4 py-2 bg-slate-800 border border-slate-700 rounded hover:border-cyan-500/50 hover:bg-slate-800/80 transition-all">
                            🔗 Twitter
                        </a>
                    @endif
                    @if(!empty($data['socials']['personal_website']))
                        <a href="{{ $data['socials']['personal_website'] }}" 
                           target="_blank"
                           class="px-4 py-2 bg-slate-800 border border-slate-700 rounded hover:border-cyan-500/50 hover:bg-slate-800/80 transition-all">
                            🔗 Website
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- About Me Section --}}
        @if(!empty($data['about_me']))
        <div class="mb-12 border-2 border-purple-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-purple-500/10 border-b border-purple-500/30 px-6 py-3">
                <p class="text-purple-400 text-sm">
                    <span class="text-purple-300">SELECT</span> about_me 
                    <span class="text-purple-300">FROM</span> users 
                    <span class="text-purple-300">WHERE</span> id = <span class="text-amber-400">{{ $data['username'] ?? 'NULL' }}</span>;
                </p>
            </div>
            <div class="p-6">
                <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $data['about_me'] }}</p>
            </div>
        </div>
        @endif

        {{-- Skills Section --}}
        @if(!empty($data['skills']) && count($data['skills']) > 0)
        <div class="mb-12 border-2 border-amber-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-amber-500/10 border-b border-amber-500/30 px-6 py-3">
                <p class="text-amber-400 text-sm">
                    <span class="text-amber-300">SELECT</span> name 
                    <span class="text-amber-300">FROM</span> skills 
                    <span class="text-amber-300">ORDER BY</span> proficiency <span class="text-amber-300">DESC</span>;
                </p>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-3">
                    @foreach($data['skills'] as $skill)
                        <span class="px-4 py-2 bg-amber-500/10 border border-amber-500/30 rounded text-amber-300">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Projects Section --}}
        @if(!empty($data['projects']) && count($data['projects']) > 0)
        <div class="mb-12 border-2 border-blue-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-blue-500/10 border-b border-blue-500/30 px-6 py-3">
                <p class="text-blue-400 text-sm">
                    <span class="text-blue-300">SELECT</span> * 
                    <span class="text-blue-300">FROM</span> projects 
                    <span class="text-blue-300">WHERE</span> user_id = <span class="text-amber-400">{{ $data['username'] ?? 'NULL' }}</span>;
                </p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($data['projects'] as $project)
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg overflow-hidden hover:border-blue-500/50 transition-all">
                            @if(!empty($project['image_path']))
                                <img src="{{ $project['image_path'] }}" 
                                     alt="{{ $project['title'] }}" 
                                     class="w-full h-48 object-cover">
                            @endif
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-slate-100 mb-2">{{ $project['title'] }}</h3>
                                @if(!empty($project['description']))
                                    <p class="text-slate-400 mb-4 text-sm">{{ $project['description'] }}</p>
                                @endif
                                @if(!empty($project['url']))
                                    <a href="{{ $project['url'] }}" 
                                       target="_blank"
                                       class="inline-block px-4 py-2 bg-blue-500/20 border border-blue-500/50 rounded text-blue-400 hover:bg-blue-500/30 transition-all text-sm">
                                        View Project →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Experience Section --}}
        @if(!empty($data['experiences']) && count($data['experiences']) > 0)
        <div class="mb-12 border-2 border-green-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-green-500/10 border-b border-green-500/30 px-6 py-3">
                <p class="text-green-400 text-sm">
                    <span class="text-green-300">SELECT</span> * 
                    <span class="text-green-300">FROM</span> experiences 
                    <span class="text-green-300">ORDER BY</span> start_date <span class="text-green-300">DESC</span>;
                </p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @foreach($data['experiences'] as $experience)
                        <div class="border-l-2 border-green-500/50 pl-6 pb-6 last:pb-0">
                            <h3 class="text-xl font-bold text-slate-100">{{ $experience['title'] }}</h3>
                            <p class="text-green-400 mb-2">{{ $experience['company'] }}</p>
                            <p class="text-slate-500 text-sm mb-2">
                                {{ $experience['start_date'] }} - {{ $experience['end_date'] ?? 'Present' }}
                                @if(!empty($experience['location']))
                                    • {{ $experience['location'] }}
                                @endif
                            </p>
                            @if(!empty($experience['description']))
                                <p class="text-slate-400 text-sm">{{ $experience['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Education Section --}}
        @if(!empty($data['education']) && count($data['education']) > 0)
        <div class="mb-12 border-2 border-pink-500/30 rounded-lg bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="bg-pink-500/10 border-b border-pink-500/30 px-6 py-3">
                <p class="text-pink-400 text-sm">
                    <span class="text-pink-300">SELECT</span> * 
                    <span class="text-pink-300">FROM</span> education 
                    <span class="text-pink-300">ORDER BY</span> start_date <span class="text-pink-300">DESC</span>;
                </p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @foreach($data['education'] as $edu)
                        <div class="border-l-2 border-pink-500/50 pl-6 pb-6 last:pb-0">
                            <h3 class="text-xl font-bold text-slate-100">{{ $edu['degree'] }}</h3>
                            @if(!empty($edu['field_of_study']))
                                <p class="text-pink-400">{{ $edu['field_of_study'] }}</p>
                            @endif
                            <p class="text-slate-400 mb-2">{{ $edu['school'] }}</p>
                            <p class="text-slate-500 text-sm mb-2">
                                {{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}
                            </p>
                            @if(!empty($edu['description']))
                                <p class="text-slate-400 text-sm">{{ $edu['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="text-center text-slate-600 text-sm mt-16">
            <p>-- Query executed successfully • {{ $data['api_request_count'] ?? 0 }} total API requests --</p>
        </div>
    </div>
</body>
</html>