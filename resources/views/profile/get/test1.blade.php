<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    
    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $data['avatar_url'] }}">
    
    <script>
        // Theme initialization - must run before body renders
        (function() {
            const theme = localStorage.getItem('theme') || 'system';
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (theme === 'dark' || (theme === 'system' && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="w-10 h-10 rounded-full ring-2 ring-blue-500">
                    <span class="font-bold text-lg">{{ $data['name'] }}</span>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#about" class="nav-link">About</a>
                    <a href="#skills" class="nav-link">Skills</a>
                    <a href="#projects" class="nav-link">Projects</a>
                    <a href="#experience" class="nav-link">Experience</a>
                    <a href="#education" class="nav-link">Education</a>
                    
                    <!-- Theme Switcher -->
                    <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-lg p-1">
                        <button id="theme-system" class="theme-btn px-2 py-1 rounded text-sm" data-theme="system" title="System Theme">
                            <i class="bi bi-circle-half"></i>
                        </button>
                        <button id="theme-light" class="theme-btn px-2 py-1 rounded text-sm" data-theme="light" title="Light Theme">
                            <i class="bi bi-sun"></i>
                        </button>
                        <button id="theme-dark" class="theme-btn px-2 py-1 rounded text-sm" data-theme="dark" title="Dark Theme">
                            <i class="bi bi-moon"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
            <div class="container mx-auto px-4 py-3 space-y-2">
                <a href="#about" class="block nav-link">About</a>
                <a href="#skills" class="block nav-link">Skills</a>
                <a href="#projects" class="block nav-link">Projects</a>
                <a href="#experience" class="block nav-link">Experience</a>
                <a href="#education" class="block nav-link">Education</a>
                
                <!-- Mobile Theme Switcher -->
                <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg p-1 mt-3">
                    <button class="theme-btn px-3 py-2 rounded text-sm" data-theme="system" title="System Theme">
                        <i class="bi bi-circle-half"></i> System
                    </button>
                    <button class="theme-btn px-3 py-2 rounded text-sm" data-theme="light" title="Light Theme">
                        <i class="bi bi-sun"></i> Light
                    </button>
                    <button class="theme-btn px-3 py-2 rounded text-sm" data-theme="dark" title="Dark Theme">
                        <i class="bi bi-moon"></i> Dark
                    </button>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="pt-24 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto text-center">
            <div class="mb-8">
                <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" 
                     class="w-32 h-32 sm:w-40 sm:h-40 rounded-full mx-auto mb-6 ring-4 ring-blue-500 shadow-xl">
                <h1 class="text-4xl sm:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ $data['name'] }}
                </h1>
                <h2 class="text-xl sm:text-2xl text-gray-600 dark:text-gray-300 mb-6">{{ $data['title'] }}</h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    {{ $data['bio'] }}
                </p>
            </div>
            
            <!-- Social Links -->
            <div class="flex justify-center space-x-4 mb-8">
                @if(!empty($data['socials']['github']))
                    <a href="{{ str_starts_with($data['socials']['github'], 'http') ? $data['socials']['github'] : 'https://github.com/' . ltrim($data['socials']['github'], '@') }}" 
                       target="_blank" class="social-btn">
                        <i class="bi bi-github text-xl"></i>
                    </a>
                @endif
                
                @if(!empty($data['socials']['linkedin']))
                    <a href="{{ str_starts_with($data['socials']['linkedin'], 'http') ? $data['socials']['linkedin'] : 'https://linkedin.com/in/' . ltrim($data['socials']['linkedin'], '@') }}" 
                       target="_blank" class="social-btn">
                        <i class="bi bi-linkedin text-xl"></i>
                    </a>
                @endif
                
                @if(!empty($data['socials']['twitter']))
                    <a href="{{ str_starts_with($data['socials']['twitter'], 'http') ? $data['socials']['twitter'] : 'https://twitter.com/' . ltrim($data['socials']['twitter'], '@') }}" 
                       target="_blank" class="social-btn">
                        <i class="bi bi-twitter text-xl"></i>
                    </a>
                @endif
                
                @if(!empty($data['socials']['personal_website']))
                    <a href="{{ $data['socials']['personal_website'] }}" target="_blank" class="social-btn">
                        <i class="bi bi-globe text-xl"></i>
                    </a>
                @endif
            </div>
            
            <a href="#about" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                Learn More <i class="bi bi-arrow-down ml-2"></i>
            </a>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
        <div class="container mx-auto max-w-4xl">
            <h2 class="section-title">About Me</h2>
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $data['about_me'] ?? $data['bio'] }}
                </p>
            </div>
        </div>
    </section>
    
    <!-- Skills Section -->
    <section id="skills" class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto max-w-6xl">
            <h2 class="section-title">Skills & Technologies</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($data['skills'] as $skill)
                    <div class="skill-tag">
                        {{ $skill }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Projects Section -->
    @if(!empty($data['projects']))
    <section id="projects" class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
        <div class="container mx-auto max-w-6xl">
            <h2 class="section-title">Featured Projects</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($data['projects'] as $project)
                    <div class="project-card">
                        @if(!empty($project['image_path']))
                            <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" 
                                 class="w-full h-48 object-cover rounded-t-lg">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3">{{ $project['title'] }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $project['description'] }}</p>
                            @if(!empty($project['url']))
                                <a href="{{ $project['url'] }}" target="_blank" 
                                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                                    View Project <i class="bi bi-arrow-up-right ml-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Experience Section -->
    @if(!empty($data['experiences']))
    <section id="experience" class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto max-w-4xl">
            <h2 class="section-title">Experience</h2>
            <div class="space-y-8">
                @foreach($data['experiences'] as $experience)
                    <div class="experience-card">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $experience['title'] }}</h3>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $experience['company'] }}</h4>
                                @if(!empty($experience['location']))
                                    <p class="text-gray-600 dark:text-gray-400">
                                        <i class="bi bi-geo-alt mr-1"></i>{{ $experience['location'] }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 sm:mt-0">
                                {{ \Carbon\Carbon::parse($experience['start_date'])->format('M Y') }} - 
                                {{ $experience['end_date'] ? \Carbon\Carbon::parse($experience['end_date'])->format('M Y') : 'Present' }}
                            </div>
                        </div>
                        @if(!empty($experience['description']))
                            <p class="text-gray-700 dark:text-gray-300">{{ $experience['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Education Section -->
    @if(!empty($data['education']))
    <section id="education" class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
        <div class="container mx-auto max-w-4xl">
            <h2 class="section-title">Education</h2>
            <div class="space-y-8">
                @foreach($data['education'] as $edu)
                    <div class="experience-card">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $edu['degree'] }}</h3>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $edu['field_of_study'] }}</h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <i class="bi bi-building mr-1"></i>{{ $edu['school'] }}
                                </p>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 sm:mt-0">
                                {{ \Carbon\Carbon::parse($edu['start_date'])->format('M Y') }} - 
                                {{ \Carbon\Carbon::parse($edu['end_date'])->format('M Y') }}
                            </div>
                        </div>
                        @if(!empty($edu['description']))
                            <p class="text-gray-700 dark:text-gray-300">{{ $edu['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Footer -->
    <footer class="py-12 px-4 sm:px-6 lg:px-8 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Built with ❤️ using Laravel & Tailwind CSS
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500">
                © {{ date('Y') }} {{ $data['name'] }}. All rights reserved.
            </p>
        </div>
    </footer>
    
    <style>
        .nav-link {
            @apply text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium;
        }
        
        .social-btn {
            @apply w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-blue-600 hover:text-white transition-all duration-200 hover:scale-110;
        }
        
        .section-title {
            @apply text-3xl font-bold text-center mb-12 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent;
        }
        
        .skill-tag {
            @apply bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-4 py-2 rounded-full text-sm font-medium text-center transition-all duration-200 hover:bg-blue-200 dark:hover:bg-blue-900/50 hover:scale-105;
        }
        
        .project-card {
            @apply bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 overflow-hidden;
        }
        
        .experience-card {
            @apply bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow duration-200;
        }
        
        .theme-btn {
            @apply transition-all duration-200 hover:bg-gray-200 dark:hover:bg-gray-600;
        }
        
        .theme-btn.active {
            @apply bg-blue-600 text-white ring-2 ring-blue-300;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }
        
        ::-webkit-scrollbar-thumb {
            @apply bg-gray-400 dark:bg-gray-600 rounded-full;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-500 dark:bg-gray-500;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Close mobile menu when clicking on nav links
            const mobileNavLinks = mobileMenu.querySelectorAll('a[href^="#"]');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
            
            // Theme switcher functionality
            const themeButtons = document.querySelectorAll('.theme-btn');
            const currentTheme = localStorage.getItem('theme') || 'system';
            
            // Set initial active state
            updateActiveThemeButton(currentTheme);
            
            themeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const theme = this.dataset.theme;
                    setTheme(theme);
                    updateActiveThemeButton(theme);
                });
            });
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                if (localStorage.getItem('theme') === 'system') {
                    applyTheme('system');
                }
            });
            
            function setTheme(theme) {
                localStorage.setItem('theme', theme);
                applyTheme(theme);
            }
            
            function applyTheme(theme) {
                const isDark = theme === 'dark' || 
                              (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            function updateActiveThemeButton(activeTheme) {
                themeButtons.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.dataset.theme === activeTheme) {
                        btn.classList.add('active');
                    }
                });
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add scroll effect to navbar
            let lastScrollTop = 0;
            const navbar = document.querySelector('nav');
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    navbar.classList.add('-translate-y-full');
                } else {
                    // Scrolling up
                    navbar.classList.remove('-translate-y-full');
                }
                
                lastScrollTop = scrollTop;
            });
            
            // Add navbar transition class
            navbar.classList.add('transition-transform', 'duration-300');
        });
    </script>
</body>
</html>