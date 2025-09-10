<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $data['name'] }} - {{ $data['title'] }} based in {{ $data['location'] }}">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Theme switcher script - runs before page load
        (function() {
            const theme = localStorage.getItem('theme') || 'system';
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <h1 class="font-semibold text-lg">{{ $data['name'] }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $data['title'] }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Social Links -->
                    <div class="hidden sm:flex items-center space-x-3">
                        @if($data['socials']['github'])
                            <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank" rel="noopener" 
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        @endif
                        @if($data['socials']['twitter'])
                            <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank" rel="noopener"
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        @endif
                        @if($data['socials']['personal_website'])
                            <a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener"
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    
                    <!-- Theme Switcher -->
                    <div class="relative">
                        <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L13.09 8.26L20 9L14 14.74L15.18 21.02L10 17.77L4.82 21.02L6 14.74L0 9L6.91 8.26L10 2Z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-24 pb-20 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="relative inline-block mb-8">
                    <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" 
                         class="w-32 h-32 sm:w-40 sm:h-40 rounded-full object-cover mx-auto shadow-xl ring-4 ring-white dark:ring-gray-700">
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white dark:border-gray-700"></div>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    {{ $data['name'] }}
                </h1>
                
                <p class="text-xl sm:text-2xl text-indigo-600 dark:text-indigo-400 font-medium mb-6">
                    {{ $data['title'] }}
                </p>
                
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-2 max-w-2xl mx-auto">
                    {{ $data['bio'] }}
                </p>
                
                <div class="flex items-center justify-center text-gray-500 dark:text-gray-400 mb-8">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $data['location'] }}
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:{{ $data['email'] }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact Me
                    </a>
                    <a href="#about" 
                       class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg border border-gray-300 dark:border-gray-600 transition-colors">
                        Learn More
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Me Section -->
    <section id="about" class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">About Me</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto"></div>
            </div>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                    {{ $data['about_me'] }}
                </p>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Skills</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto"></div>
            </div>
            
            <div class="flex flex-wrap gap-3 justify-center">
                @foreach($data['skills'] as $skill)
                    <span class="px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full border border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md transition-all duration-300 font-medium">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Projects</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($data['projects'] as $project)
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-xl transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                        @if($project['image_path'])
                            <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" 
                                 class="w-full h-48 object-cover rounded-lg mb-6">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg mb-6 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                        
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">{{ $project['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">{{ $project['description'] }}</p>
                        
                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener"
                           class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium transition-colors">
                            View Project
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Experience</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto"></div>
            </div>
            
            <div class="space-y-8">
                @foreach($data['experiences'] as $experience)
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $experience['title'] }}</h3>
                                <p class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $experience['company'] }}</p>
                                @if($experience['location'])
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $experience['location'] }}</p>
                                @endif
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm mt-2 sm:mt-0">
                                {{ \Carbon\Carbon::parse($experience['start_date'])->format('M Y') }} - 
                                {{ \Carbon\Carbon::parse($experience['end_date'])->format('M Y') }}
                            </div>
                        </div>
                        @if($experience['description'])
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $experience['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Education</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto"></div>
            </div>
            
            <div class="space-y-8">
                @foreach($data['education'] as $education)
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $education['degree'] }}</h3>
                                <p class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $education['school'] }}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $education['field_of_study'] }}</p>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm mt-2 sm:mt-0">
                                {{ \Carbon\Carbon::parse($education['start_date'])->format('M Y') }} - 
                                {{ \Carbon\Carbon::parse($education['end_date'])->format('M Y') }}
                            </div>
                        </div>
                        @if($education['description'])
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $education['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 dark:bg-black text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="mb-4 sm:mb-0">
                    <p class="text-gray-300">Powered by <a href="https://getmy.name" class="text-indigo-400 hover:text-indigo-300 transition-colors">getmy.name</a> from <a href="https://mtex.dev" class="text-indigo-400 hover:text-indigo-300 transition-colors">mtex.dev</a></p>
                </div>
                <div class="text-gray-500 text-sm">
                    API Requests: {{ number_format($data['api_request_count']) }}
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-800 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} {{ $data['name'] }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Theme switcher functionality
        const themeToggle = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        
        // Get current theme
        const currentTheme = localStorage.getItem('theme') || 'system';
        
        // Function to update icons
        function updateThemeIcons() {
            if (document.documentElement.classList.contains('dark')) {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }
        
        // Initialize icons
        updateThemeIcons();
        
        // Theme toggle click handler
        themeToggle.addEventListener('click', function() {
            const currentTheme = localStorage.getItem('theme') || 'system';
            let newTheme;
            
            if (currentTheme === 'light') {
                newTheme = 'dark';
            } else if (currentTheme === 'dark') {
                newTheme = 'system';
            } else {
                newTheme = 'light';
            }
            
            localStorage.setItem('theme', newTheme);
            
            // Apply theme
            if (newTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (newTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                // system
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            updateThemeIcons();
        });
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (localStorage.getItem('theme') === 'system') {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                updateThemeIcons();
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>