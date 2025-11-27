<!DOCTYPE html>
<html lang="en" x-data="themeManager()" x-init="initTheme()" :class="theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-getmyname-50 dark:from-slate-900 dark:via-slate-800 dark:to-getmyname-900 min-h-screen transition-all duration-300">
    
    <!-- Theme Switcher -->
    <div class="fixed top-4 right-4 z-50 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-full p-2 shadow-lg border border-slate-200 dark:border-slate-700">
        <div class="flex space-x-1">
            <button @click="setTheme('light')" :class="theme === 'light' ? 'bg-amber-500 text-white ring-2 ring-amber-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'" 
                    class="p-2 rounded-full transition-all duration-200">
                <i class="bi bi-sun-fill text-sm"></i>
            </button>
            <button @click="setTheme('dark')" :class="theme === 'dark' ? 'bg-getmyname-600 text-white ring-2 ring-getmyname-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'" 
                    class="p-2 rounded-full transition-all duration-200">
                <i class="bi bi-moon-stars-fill text-sm"></i>
            </button>
            <button @click="setTheme('system')" :class="theme === 'system' ? 'bg-slate-600 text-white ring-2 ring-slate-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'" 
                    class="p-2 rounded-full transition-all duration-200">
                <i class="bi bi-display text-sm"></i>
            </button>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <!-- Hero Section -->
        <section class="relative mb-16">
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 md:p-12 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transform rotate-1 hover:rotate-0 transition-transform duration-300">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-shrink-0">
                        <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" 
                             class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover shadow-lg ring-4 ring-white dark:ring-slate-700 hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">
                            {{ $data['name'] }}
                        </h1>
                        <h2 class="text-xl md:text-2xl text-getmyname-600 dark:text-getmyname-400 font-medium mb-4">
                            {{ $data['title'] }}
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed max-w-2xl">
                            {{ $data['bio'] }}
                        </p>
                        
                        <!-- Social Links -->
                        <div class="flex justify-center md:justify-start space-x-4 mt-6">
                            @if(isset($data['socials']['github']))
                                <a href="{{ str_starts_with($data['socials']['github'], 'http') ? $data['socials']['github'] : 'https://github.com/' . ltrim($data['socials']['github'], '@') }}" 
                                   target="_blank" rel="noopener" 
                                   class="p-3 bg-slate-100 dark:bg-slate-700 rounded-full hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors duration-200 group">
                                    <i class="bi bi-github text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-lg"></i>
                                </a>
                            @endif
                            @if(isset($data['socials']['linkedin']))
                                <a href="{{ str_starts_with($data['socials']['linkedin'], 'http') ? $data['socials']['linkedin'] : 'https://linkedin.com/in/' . ltrim($data['socials']['linkedin'], '@') }}" 
                                   target="_blank" rel="noopener"
                                   class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors duration-200 group">
                                    <i class="bi bi-linkedin text-blue-700 dark:text-blue-400 group-hover:text-blue-800 dark:group-hover:text-blue-300 text-lg"></i>
                                </a>
                            @endif
                            @if(isset($data['socials']['twitter']))
                                <a href="{{ str_starts_with($data['socials']['twitter'], 'http') ? $data['socials']['twitter'] : 'https://twitter.com/' . ltrim($data['socials']['twitter'], '@') }}" 
                                   target="_blank" rel="noopener"
                                   class="p-3 bg-sky-100 dark:bg-sky-900/30 rounded-full hover:bg-sky-200 dark:hover:bg-sky-800/50 transition-colors duration-200 group">
                                    <i class="bi bi-twitter text-sky-700 dark:text-sky-400 group-hover:text-sky-800 dark:group-hover:text-sky-300 text-lg"></i>
                                </a>
                            @endif
                            @if(isset($data['socials']['personal_website']))
                                <a href="{{ $data['socials']['personal_website'] }}" 
                                   target="_blank" rel="noopener"
                                   class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-full hover:bg-emerald-200 dark:hover:bg-emerald-800/50 transition-colors duration-200 group">
                                    <i class="bi bi-globe text-emerald-700 dark:text-emerald-400 group-hover:text-emerald-800 dark:group-hover:text-emerald-300 text-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About Me -->
                <section class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transform -rotate-1 hover:rotate-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <i class="bi bi-person-fill text-getmyname-600 dark:text-getmyname-400 mr-3"></i>
                        About Me
                    </h3>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-lg">
                        {{ $data['about_me'] }}
                    </p>
                </section>

                <!-- Projects -->
                <section class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transform rotate-0.5 hover:rotate-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
                        <i class="bi bi-code-square text-getmyname-600 dark:text-getmyname-400 mr-3"></i>
                        Featured Projects
                    </h3>
                    <div class="grid gap-6">
                        @foreach($data['projects'] as $project)
                            <div class="bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-6 hover:shadow-lg transition-shadow duration-300 border border-slate-200/50 dark:border-slate-600/50">
                                @if(isset($project['image_path']))
                                    <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" 
                                         class="w-full h-48 object-cover rounded-xl mb-4 hover:scale-105 transition-transform duration-300">
                                @endif
                                <h4 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">
                                    {{ $project['title'] }}
                                </h4>
                                <p class="text-slate-600 dark:text-slate-300 mb-4 leading-relaxed">
                                    {{ $project['description'] }}
                                </p>
                                @if(isset($project['url']))
                                    <a href="{{ $project['url'] }}" target="_blank" rel="noopener" 
                                       class="inline-flex items-center px-4 py-2 bg-getmyname-600 hover:bg-getmyname-700 text-white rounded-full transition-colors duration-200 text-sm font-medium">
                                        <i class="bi bi-box-arrow-up-right mr-2"></i>
                                        View Project
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Experience -->
                <section class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transform -rotate-0.5 hover:rotate-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
                        <i class="bi bi-briefcase-fill text-getmyname-600 dark:text-getmyname-400 mr-3"></i>
                        Experience
                    </h3>
                    <div class="space-y-6">
                        @foreach($data['experiences'] as $experience)
                            <div class="relative pl-8 border-l-2 border-getmyname-200 dark:border-getmyname-800 last:border-l-0">
                                <div class="absolute -left-2 top-0 w-4 h-4 bg-getmyname-600 dark:bg-getmyname-400 rounded-full"></div>
                                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                                    <h4 class="text-xl font-semibold text-slate-900 dark:text-white">
                                        {{ $experience['title'] }}
                                    </h4>
                                    <h5 class="text-lg font-medium text-getmyname-600 dark:text-getmyname-400 mb-2">
                                        {{ $experience['company'] }} • {{ $experience['location'] }}
                                    </h5>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
                                        {{ date('M Y', strtotime($experience['start_date'])) }} - 
                                        {{ $experience['end_date'] ? date('M Y', strtotime($experience['end_date'])) : 'Present' }}
                                    </p>
                                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                                        {{ $experience['description'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                
                <!-- Skills -->
                <section class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transform rotate-1 hover:rotate-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <i class="bi bi-gear-fill text-getmyname-600 dark:text-getmyname-400 mr-3"></i>
                        Skills
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($data['skills'] as $skill)
                            <span class="px-4 py-2 bg-gradient-to-r from-getmyname-500 to-purple-600 text-white rounded-full text-sm font-medium hover:shadow-lg transition-shadow duration-300 hover:scale-105 transform">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </section>

                <!-- Education -->
                <section class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transform -rotate-1 hover:rotate-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <i class="bi bi-mortarboard-fill text-getmyname-600 dark:text-getmyname-400 mr-3"></i>
                        Education
                    </h3>
                    <div class="space-y-6">
                        @foreach($data['education'] as $education)
                            <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6 hover:shadow-md transition-shadow duration-300 border border-slate-200/50 dark:border-slate-600/50">
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white">
                                    {{ $education['degree'] }}
                                </h4>
                                <h5 class="text-md font-medium text-getmyname-600 dark:text-getmyname-400 mb-1">
                                    {{ $education['field_of_study'] }}
                                </h5>
                                <p class="text-slate-700 dark:text-slate-300 mb-2">
                                    {{ $education['school'] }}
                                </p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
                                    {{ date('Y', strtotime($education['start_date'])) }} - {{ date('Y', strtotime($education['end_date'])) }}
                                </p>
                                @if(isset($education['description']))
                                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                                        {{ $education['description'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>

            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-16 text-center py-8">
            <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-slate-200/50 dark:border-slate-700/50 inline-block">
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Powered by <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://getmy.name" target="_blank" rel="noopener">getmy.name</a> from <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://mtex.dev" target="_blank" rel="noopener">mtex.dev</a>
                </p>
            </div>
        </footer>

    </div>

    <script>
        function themeManager() {
            return {
                theme: 'system',
                
                initTheme() {
                    this.theme = localStorage.getItem('theme') || 'system';
                    this.applyTheme();
                    
                    // Listen for system theme changes
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                        if (this.theme === 'system') {
                            this.applyTheme();
                        }
                    });
                },
                
                setTheme(newTheme) {
                    this.theme = newTheme;
                    localStorage.setItem('theme', newTheme);
                    this.applyTheme();
                },
                
                applyTheme() {
                    if (this.theme === 'system') {
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    } else if (this.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>

</body>
</html>