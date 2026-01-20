<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $data['bio'] ?? $data['name'] . "'s developer profile on GetMyName" }}">
    
    <title>{{ $data['name'] }} (@ {{ $data['username'] }}) - GetMyName Profile</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 selection:bg-getmyname-500 selection:text-white"
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
>

    <!-- Navigation / Header -->
    <nav class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo / Identity -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('lander') }}" class="group flex items-center gap-2">
                        <div class="bg-getmyname-500 text-white p-1.5 rounded-lg group-hover:bg-getmyname-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight hidden sm:block">getmyname</span>
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    <!-- CTA -->
                    <a href="{{ route('lander') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gray-900 hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 transition-colors shadow-sm">
                        Create your Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Hero Section -->
            <section class="relative animate-fade-in-up">
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-getmyname-50 dark:bg-getmyname-900/10 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col md:flex-row gap-8 md:items-start">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-getmyname-400 to-blue-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                                <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" 
                                     class="relative w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-xl">
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 space-y-4 text-center md:text-left">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                                    {{ $data['name'] }}
                                </h1>
                                <p class="text-lg text-getmyname-600 dark:text-getmyname-400 font-medium mt-1">
                                    {{ $data['title'] ?? 'Developer' }}
                                </p>
                                <div class="flex items-center justify-center md:justify-start gap-4 mt-3 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ '@' . $data['username'] }}
                                    </span>
                                    @if($data['location'])
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $data['location'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($data['bio'])
                                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                                    {{ $data['bio'] }}
                                </p>
                            @endif

                            <!-- Social Links (Hero) -->
                            @if(!empty($data['socials']))
                                <div class="flex flex-wrap justify-center md:justify-start gap-3 pt-2">
                                    @foreach($data['socials'] as $platform => $handle)
                                        @continue(empty($handle))
                                        @php
                                            $url = match($platform) {
                                                'github' => "https://github.com/{$handle}",
                                                'twitter' => "https://twitter.com/{$handle}",
                                                'linkedin' => "https://linkedin.com/in/{$handle}",
                                                'personal_website' => $handle,
                                                'instagram' => "https://instagram.com/{$handle}",
                                                'youtube_url' => $handle,
                                                'dev_to' => "https://dev.to/{$handle}",
                                                default => "#"
                                            };
                                            
                                            $icon = match($platform) {
                                                'github' => '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>',
                                                'twitter' => '<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>',
                                                'linkedin' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>',
                                                'personal_website' => '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
                                                'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>',
                                                default => '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line>'
                                            };
                                        @endphp
                                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" 
                                           class="p-2 bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 hover:text-getmyname-600 dark:hover:text-getmyname-400 hover:bg-getmyname-50 dark:hover:bg-getmyname-900/20 rounded-lg transition-all"
                                           title="{{ ucfirst(str_replace('_', ' ', $platform)) }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                {!! $icon !!}
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
                <!-- Left Column (About, Skills, Contact) -->
                <div class="space-y-8 lg:col-span-1">
                    
                    <!-- About Me -->
                    @if($data['about_me'])
                        <section class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                About Me
                            </h2>
                            <div class="prose prose-sm dark:prose-invert prose-green max-w-none text-gray-600 dark:text-gray-300">
                                {!! Str::markdown($data['about_me']) !!}
                            </div>
                        </section>
                    @endif

                    <!-- Skills -->
                    @if(!empty($data['skills']))
                        <section class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Skills
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($data['skills'] as $skill)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-transparent hover:border-getmyname-300 dark:hover:border-getmyname-600 transition-colors cursor-default">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <!-- Contact/Email -->
                    <section class="bg-gradient-to-br from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 rounded-3xl p-6 shadow-sm border border-gray-800 text-white">
                        <h2 class="text-lg font-bold mb-2">Get in touch</h2>
                        <p class="text-gray-400 text-sm mb-4">Interested in working together? Drop me a line.</p>
                        <a href="mailto:{{ $data['email'] }}" class="inline-flex w-full justify-center items-center px-4 py-2 bg-white text-gray-900 rounded-lg text-sm font-bold hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $data['email'] }}
                        </a>
                    </section>
                </div>

                <!-- Right Column (Projects, Exp, Edu) -->
                <div class="space-y-12 lg:col-span-2">
                    
                    <!-- Projects -->
                    @if(!empty($data['projects']))
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                                <span class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </span>
                                Featured Projects
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($data['projects'] as $project)
                                    <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-getmyname-200 dark:hover:border-getmyname-900/50 transition-all duration-300">
                                        <div class="aspect-video bg-gray-100 dark:bg-gray-900 overflow-hidden relative">
                                            @if($project['image_path'])
                                                <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-700">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                            
                                            <!-- Hover Overlay Link -->
                                            @if($project['url'])
                                                <a href="{{ $project['url'] }}" target="_blank" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity backdrop-blur-[2px]">
                                                    <span class="inline-flex items-center px-4 py-2 bg-white rounded-full text-sm font-bold text-gray-900 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform">
                                                        Visit Project <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                    </span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2 truncate">{{ $project['title'] }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
                                                {{ $project['description'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <!-- Experience -->
                    @if(!empty($data['experiences']))
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                                <span class="p-2 bg-getmyname-50 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                Experience
                            </h2>
                            <div class="space-y-6">
                                @foreach($data['experiences'] as $exp)
                                    <div class="relative pl-8 border-l-2 border-gray-100 dark:border-gray-800 pb-2 last:pb-0">
                                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white dark:bg-gray-900 border-2 border-getmyname-500"></div>
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-1 mb-2">
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $exp['title'] }}</h3>
                                            <span class="text-xs font-mono font-medium px-2 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($exp['start_date'])->format('M Y') }} — 
                                                {{ $exp['end_date'] ? \Carbon\Carbon::parse($exp['end_date'])->format('M Y') : 'Present' }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">{{ $exp['company'] }} <span class="font-normal text-gray-400">• {{ $exp['location'] }}</span></p>
                                        @if($exp['description'])
                                            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed max-w-2xl">
                                                {{ $exp['description'] }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <!-- Education -->
                    @if(!empty($data['education']))
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                                <span class="p-2 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg text-yellow-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                </span>
                                Education
                            </h2>
                            <div class="grid gap-4">
                                @foreach($data['education'] as $edu)
                                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row justify-between items-start gap-4">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $edu['school'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $edu['degree'] }}</p>
                                            @if($edu['field_of_study'])
                                                <p class="text-xs text-gray-500 mt-1">{{ $edu['field_of_study'] }}</p>
                                            @endif
                                        </div>
                                        <span class="text-xs font-mono text-gray-400 bg-gray-50 dark:bg-gray-900 px-2 py-1 rounded">
                                            {{ \Carbon\Carbon::parse($edu['start_date'])->format('Y') }} — 
                                            {{ $edu['end_date'] ? \Carbon\Carbon::parse($edu['end_date'])->format('Y') : 'Present' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
            <div class="flex items-center gap-2 mb-4 opacity-50">
                <div class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 p-1 rounded">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <span class="font-bold text-gray-900 dark:text-white">getmyname</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                Powered by <a href="{{ route('lander') }}" class="font-bold text-gray-900 dark:text-white hover:underline">GetMyName</a>.
                Create your developer profile in seconds.
            </p>
        </div>
    </footer>
</body>
</html>