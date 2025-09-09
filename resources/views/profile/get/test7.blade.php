<!DOCTYPE html>
<html lang="en" x-data="page()" x-init="init()" :class="{ 'dark': isDark }">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="description" content="{{ $data['bio'] ?? '' }}" />
    <title>{{ $data['name'] ?? 'Profile' }} - {{ $data['title'] ?? '' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    @php
        if (! function_exists('formatDate')) {
            function formatDate($d, $format = 'M Y') {
                if (!$d) return '';
                try {
                    return \Carbon\Carbon::parse($d)->format($format);
                } catch (\Throwable $e) {
                    return 'Invalid Date';
                }
            }
        }

        if (! function_exists('rangeLabel')) {
            function rangeLabel($start, $end) {
                $s = $start ? formatDate($start) : null;
                if (!$end || trim($end) === '') {
                    return $s ? "{$s} - Present" : 'Present';
                }
                $e = formatDate($end);
                return ($s ? "{$s} - {$e}" : "{$e}");
            }
        }
    @endphp

    <style>
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -31px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: theme('colors.blue.500');
            border: 2px solid theme('colors.gray.100');
        }
        .dark .timeline-item::before {
            background-color: theme('colors.blue.400');
            border-color: theme('colors.gray.800');
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 font-sans transition-colors duration-300">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg border-b border-gray-200/80 dark:border-gray-700/80 h-16" x-data="{ mobileOpen: false }" @click.away="mobileOpen = false">
        <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="#top" class="text-xl font-bold tracking-wider uppercase text-blue-600 dark:text-blue-400">
                {{ explode(' ', $data['name'] ?? '')[0] ?? ($data['username'] ?? 'Profile') }}
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#experience" class="nav-link">Experience</a>
                <a href="#skills" class="nav-link">Skills</a>
                <a href="#projects" class="nav-link">Projects</a>
            </div>

            <div class="flex items-center gap-2">
                <div class="flex bg-gray-200 dark:bg-gray-700 rounded-full p-1" role="tablist">
                    <button @click="setTheme('light')" :class="theme === 'light' && 'bg-blue-500 text-white'" class="p-2 rounded-full transition-all text-sm" title="Light"><i class="bi bi-sun-fill"></i></button>
                    <button @click="setTheme('system')" :class="theme === 'system' && 'bg-blue-500 text-white'" class="p-2 rounded-full transition-all text-sm" title="System"><i class="bi bi-circle-half"></i></button>
                    <button @click="setTheme('dark')" :class="theme === 'dark' && 'bg-blue-500 text-white'" class="p-2 rounded-full transition-all text-sm" title="Dark"><i class="bi bi-moon-stars-fill"></i></button>
                </div>
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" aria-label="Toggle menu">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>
        </div>

        <div x-show="mobileOpen" x-transition class="md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col space-y-2 px-4 py-3">
                <a href="#experience" @click="mobileOpen = false" class="nav-link-mobile">Experience</a>
                <a href="#skills" @click="mobileOpen = false" class="nav-link-mobile">Skills</a>
                <a href="#projects" @click="mobileOpen = false" class="nav-link-mobile">Projects</a>
            </div>
        </div>
    </nav>

    <main id="top" class="pt-16">
        <section class="min-h-[calc(100vh-4rem)] flex items-center py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-12 items-center">
                <div class="md:col-span-2 flex flex-col items-center md:items-start text-center md:text-left">
                    <img src="{{ $data['avatar_url'] ?? '' }}" alt="{{ $data['name'] ?? 'Avatar' }}" class="scroll-reveal w-40 h-40 rounded-full object-cover mb-6 ring-4 ring-offset-4 ring-offset-gray-100 dark:ring-offset-gray-900 ring-blue-500" />
                    <h1 class="scroll-reveal text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-gray-50 leading-tight mb-2" style="transition-delay: 100ms;">
                        {{ $data['name'] ?? ($data['username'] ?? 'Unnamed') }}
                    </h1>
                    <p class="scroll-reveal text-2xl text-blue-600 dark:text-blue-400 font-semibold mb-4" style="transition-delay: 200ms;">{{ $data['title'] ?? '' }}</p>
                    @if(!empty($data['location']))
                        <p class="scroll-reveal text-lg text-gray-600 dark:text-gray-400 mb-6 flex items-center gap-2" style="transition-delay: 300ms;">
                            <i class="bi bi-geo-alt-fill"></i> {{ $data['location'] }}
                        </p>
                    @endif
                    <div class="scroll-reveal flex flex-wrap justify-center md:justify-start gap-4" style="transition-delay: 400ms;">
                        @php
                            $socials = [
                                'github' => ['icon' => 'bi-github', 'base' => 'https://github.com/'],
                                'twitter' => ['icon' => 'bi-twitter-x', 'base' => 'https://twitter.com/'],
                                'linkedin' => ['icon' => 'bi-linkedin', 'base' => 'https://linkedin.com/in/'],
                                'personal_website' => ['icon' => 'bi-globe', 'base' => ''],
                            ];
                        @endphp
                        @foreach($socials as $key => $details)
                            @if(!empty($data['socials'][$key]))
                                <a href="{{ $details['base'] }}{{ $data['socials'][$key] }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="{{ ucfirst($key) }}">
                                    <i class="bi {{ $details['icon'] }}"></i>
                                </a>
                            @endif
                        @endforeach
                        @if(!empty($data['email']))
                           <a href="mailto:{{ $data['email'] }}" class="social-link" aria-label="Email">
                                <i class="bi bi-envelope-fill"></i>
                           </a>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-3">
                    <div class="scroll-reveal bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg" style="transition-delay: 500ms;">
                        <h2 class="text-3xl font-bold mb-4 text-blue-600 dark:text-blue-400">About Me</h2>
                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($data['about_me'] ?? '')) !!}
                        </div>
                         @if(!empty($data['email']))
                            <a href="mailto:{{ $data['email'] }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-transform hover:scale-105">
                                Contact Me
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="experience" class="py-24 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold mb-16 text-center text-gray-800 dark:text-gray-200 scroll-reveal">Career & Education</h2>
                <div class="relative border-l-2 border-gray-200 dark:border-gray-700 ml-2 pl-8 space-y-12">
                    @if(!empty($data['experiences']) && is_array($data['experiences']))
                        @foreach($data['experiences'] as $item)
                            <div class="relative timeline-item scroll-reveal">
                                <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-1">{{ rangeLabel($item['start_date'] ?? null, $item['end_date'] ?? null) }}</p>
                                <h3 class="text-2xl font-semibold">{{ $item['title'] ?? '' }}</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mb-2">{{ $item['company'] ?? '' }}</p>
                                @if(!empty($item['description']))
                                    <p class="text-gray-700 dark:text-gray-300">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                    @if(!empty($data['education']) && is_array($data['education']))
                        @foreach($data['education'] as $item)
                             <div class="relative timeline-item scroll-reveal">
                                <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-1">{{ rangeLabel($item['start_date'] ?? null, $item['end_date'] ?? null) }}</p>
                                <h3 class="text-2xl font-semibold">{{ $item['degree'] ?? '' }} at {{ $item['school'] ?? '' }}</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mb-2">{{ $item['field_of_study'] ?? '' }}</p>
                                @if(!empty($item['description']))
                                    <p class="text-gray-700 dark:text-gray-300">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section id="skills" class="py-24 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-8 text-gray-800 dark:text-gray-200 scroll-reveal">Technologies I Use</h2>
                <div class="flex flex-wrap justify-center gap-4 scroll-reveal" style="transition-delay: 150ms;">
                    @forelse($data['skills'] as $skill)
                        <span class="skill-badge">{{ $skill }}</span>
                    @empty
                        <p class="text-lg text-gray-600 dark:text-gray-400">No skills listed yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="projects" class="py-24 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl font-bold mb-16 text-center text-gray-800 dark:text-gray-200 scroll-reveal">Featured Projects</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($data['projects'] as $project)
                        <a href="{{ $project['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="block bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden group scroll-reveal transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                            @if(!empty($project['image_path']))
                                <div class="h-56 overflow-hidden">
                                    <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project image' }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-50">{{ $project['title'] ?? 'Untitled' }}</h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm mb-4">{{ $project['description'] }}</p>
                                <span class="font-medium text-blue-600 dark:text-blue-400 flex items-center gap-2">
                                    View Project <i class="bi bi-arrow-up-right transition-transform duration-300 group-hover:rotate-45"></i>
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-center text-gray-600 dark:text-gray-400 text-lg col-span-full">No projects to show.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <footer class="py-10 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} {{ $data['name'] ?? 'Profile' }}. All Rights Reserved.
            </p>
        </div>
    </footer>

    <script>
        function page() {
            return {
                theme: localStorage.getItem('theme') || 'system',
                isDark: false,

                init() {
                    this.updateTheme();
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                        if (this.theme === 'system') this.updateTheme();
                    });
                    this.initScrollReveal();
                    this.initSmoothScroll();
                },

                setTheme(newTheme) {
                    this.theme = newTheme;
                    localStorage.setItem('theme', newTheme);
                    this.updateTheme();
                },

                updateTheme() {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.isDark = this.theme === 'dark' || (this.theme === 'system' && prefersDark);
                },

                initScrollReveal() {
                    if (!('IntersectionObserver' in window)) return;
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('revealed');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
                },

                initSmoothScroll() {
                    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                        anchor.addEventListener('click', (e) => {
                            const href = anchor.getAttribute('href');
                            const target = document.querySelector(href);
                            if (target) {
                                e.preventDefault();
                                const offset = document.querySelector('nav').offsetHeight;
                                window.scrollTo({
                                    top: target.offsetTop - offset,
                                    behavior: 'smooth'
                                });
                            }
                        });
                    });
                }
            };
        }
    </script>
</body>
</html>