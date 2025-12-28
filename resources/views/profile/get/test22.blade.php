<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased dark:bg-slate-950 dark:text-slate-200">

    <div class="relative w-full h-64 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
        <div class="absolute inset-0 bg-black/20"></div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 pb-12 relative z-10">
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="p-8 sm:p-12">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="flex-shrink-0">
                        <img src="{{ $data['avatar_url'] }}"
                             alt="{{ $data['name'] }}"
                             class="h-40 w-40 rounded-2xl object-cover ring-4 ring-white dark:ring-slate-900 shadow-lg">
                    </div>
                    
                    <div class="flex-grow space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                                    {{ $data['name'] }}
                                </h1>
                                <p class="text-xl text-indigo-600 dark:text-indigo-400 font-medium mt-1">
                                    {{ $data['title'] }}
                                </p>
                            </div>
                            
                            @if(!empty($data['socials']))
                            <div class="flex gap-3">
                                @foreach($data['socials'] as $platform => $link)
                                    @if($link)
                                        <a href="{{ $link }}" target="_blank" class="p-2 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-indigo-100 hover:text-indigo-600 dark:hover:bg-slate-700 transition-colors">
                                            <span class="sr-only">{{ ucfirst($platform) }}</span>
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12c0-5.523-4.477-10-10-10z"/></svg>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $data['location'] ?? 'Remote' }}
                        </div>
                        
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl">
                            {{ $data['bio'] }}
                        </p>

                        @if(!empty($data['skills']))
                        <div class="flex flex-wrap gap-2 pt-2">
                            @foreach($data['skills'] as $skill)
                                <span class="px-3 py-1 text-xs font-semibold rounded-md bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-800">
                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <div class="lg:col-span-2 p-8 sm:p-12 border-r border-slate-200 dark:border-slate-800 space-y-12">
                        
                        @if(!empty($data['about_me']))
                        <section>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">About Me</h3>
                            <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                                {!! nl2br(e($data['about_me'])) !!}
                            </div>
                        </section>
                        @endif

                        @if(!empty($data['projects']))
                        <section>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Featured Projects</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($data['projects'] as $project)
                                    <a href="{{ $project['url'] }}" target="_blank" class="group block h-full bg-slate-50 dark:bg-slate-800/50 rounded-xl overflow-hidden hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500">
                                        @if($project['image_path'])
                                            <div class="h-48 overflow-hidden">
                                                <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        @else
                                            <div class="h-48 bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                                                <span class="text-4xl">🚀</span>
                                            </div>
                                        @endif
                                        <div class="p-6">
                                            <h4 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                {{ $project['title'] }}
                                            </h4>
                                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 line-clamp-3">
                                                {{ $project['description'] }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                        @endif

                        @if(!empty($data['api_request_count']))
                            <div class="bg-indigo-900 rounded-xl p-6 text-white flex items-center justify-between">
                                <span class="font-medium">Total API Interactions</span>
                                <span class="text-2xl font-bold font-mono">{{ number_format($data['api_request_count']) }}</span>
                            </div>
                        @endif

                    </div>

                    <div class="p-8 sm:p-12 bg-slate-50 dark:bg-slate-900/50 space-y-12">
                        
                        @if(!empty($data['experiences']))
                        <section>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                                <span>Experience</span>
                            </h3>
                            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-1.5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent dark:before:via-slate-700">
                                @foreach($data['experiences'] as $experience)
                                    <div class="relative pl-8 group">
                                        <div class="absolute left-0 top-1.5 mt-0.5 h-3 w-3 rounded-full border-2 border-indigo-600 bg-white dark:bg-slate-900 dark:border-indigo-500 group-hover:scale-125 transition-transform"></div>
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-baseline mb-1">
                                            <h4 class="text-base font-bold text-slate-900 dark:text-white">{{ $experience['title'] }}</h4>
                                            <span class="text-xs font-mono text-slate-500 dark:text-slate-400">
                                                {{ \Carbon\Carbon::parse($experience['start_date'])->format('M Y') }} — 
                                                {{ $experience['end_date'] ? \Carbon\Carbon::parse($experience['end_date'])->format('M Y') : 'Present' }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-2">
                                            {{ $experience['company'] }} 
                                            @if($experience['location']) • {{ $experience['location'] }} @endif
                                        </div>
                                        <p class="text-sm text-slate-600 dark:text-slate-400">
                                            {{ $experience['description'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                        @endif

                        @if(!empty($data['education']))
                        <section>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Education</h3>
                            <div class="space-y-6">
                                @foreach($data['education'] as $edu)
                                    <div class="relative pl-6 border-l-2 border-slate-200 dark:border-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors">
                                        <h4 class="text-base font-bold text-slate-900 dark:text-white">{{ $edu['school'] }}</h4>
                                        <div class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">
                                            {{ $edu['degree'] }} in {{ $edu['field_of_study'] }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1 mb-2 font-mono">
                                            {{ \Carbon\Carbon::parse($edu['start_date'])->format('Y') }} — 
                                            {{ $edu['end_date'] ? \Carbon\Carbon::parse($edu['end_date'])->format('Y') : 'Present' }}
                                        </div>
                                        @if($edu['description'])
                                        <p class="text-sm text-slate-600 dark:text-slate-400">
                                            {{ $edu['description'] }}
                                        </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        
        <footer class="mt-12 text-center text-slate-500 text-sm">
            <p>&copy; {{ date('Y') }} {{ $data['name'] }}. All rights reserved.</p>
        </footer>
    </main>
</body>
</html>