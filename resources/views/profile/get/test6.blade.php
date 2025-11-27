<!DOCTYPE html>
<html lang="en" x-data="themeManager()" x-init="init()" :class="theme">
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
                    $ts = strtotime($d);
                    if ($ts === false) return $d;
                    return date($format, $ts);
                } catch (\Throwable $e) {
                    return $d;
                }
            }
        }

        if (! function_exists('rangeLabel')) {
            function rangeLabel($start, $end) {
                $s = formatDate($start);
                if (!$end || trim($end) === '') {
                    return $s ? "{$s} - Present" : 'Present';
                }
                $e = formatDate($end);
                return ($s ? "{$s} - {$e}" : "{$e}");
            }
        }

        if (! function_exists('cleanHandle')) {
            function cleanHandle($value) {
                if (!$value) return '';
                return str_replace(['https://', 'http://', 'www.', 'linkedin.com/in/', 'linkedin.com/', 'github.com/', 'twitter.com/', '@', '/'], '', trim($value));
            }
        }
    @endphp
</head>

<body class="font-sans bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-50 transition-colors duration-300">
    <div class="relative z-10">
        <nav role="navigation" class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-sm border-b border-gray-200 dark:border-gray-700 h-16" x-data="{ mobileOpen: false }">
            <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center">
                    <a href="#top" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        {{ explode(' ', $data['name'] ?? '')[0] ?? ($data['username'] ?? 'Profile') }}
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">About</a>
                    <a href="#skills" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Skills</a>
                    <a href="#experience" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Experience</a>
                    <a href="#projects" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Projects</a>
                    <a href="#education" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Education</a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1" role="tablist" aria-label="Theme switcher">
                        <button @click="setTheme('light')" :class="theme === 'light' ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'" class="p-2 rounded-md transition-all duration-200 text-sm" aria-pressed="false" title="Light">
                            <i class="bi bi-sun-fill" aria-hidden="true"></i>
                        </button>
                        <button @click="setTheme('system')" :class="theme === 'system' ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'" class="p-2 rounded-md transition-all duration-200 text-sm" title="System">
                            <i class="bi bi-circle-half" aria-hidden="true"></i>
                        </button>
                        <button @click="setTheme('dark')" :class="theme === 'dark' ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'" class="p-2 rounded-md transition-all duration-200 text-sm" title="Dark">
                            <i class="bi bi-moon-stars-fill" aria-hidden="true"></i>
                        </button>
                    </div>

                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle menu">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col space-y-2 px-4 py-3">
                    <a href="#about" @click="mobileOpen = false" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">About</a>
                    <a href="#skills" @click="mobileOpen = false" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Skills</a>
                    <a href="#experience" @click="mobileOpen = false" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Experience</a>
                    <a href="#projects" @click="mobileOpen = false" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Projects</a>
                    <a href="#education" @click="mobileOpen = false" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Education</a>
                </div>
            </div>
        </nav>

        <main id="top" class="min-h-screen pt-16">
            <section class="h-[calc(100vh-4rem)] flex items-center justify-center text-center px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto scroll-reveal">
                    <div class="flex flex-col items-center mb-8">
                        <img src="{{ $data['avatar_url'] ?? '' }}" alt="{{ $data['name'] ?? 'Avatar' }}" class="w-32 h-32 rounded-full object-cover ring-4 ring-blue-400 dark:ring-blue-600 mb-4" />
                        <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 dark:text-gray-50 leading-tight mb-2">
                            {{ $data['name'] ?? ($data['username'] ?? 'Unnamed') }}
                        </h1>
                        <p class="text-2xl text-gray-700 dark:text-gray-300 font-medium mb-4">{{ $data['title'] ?? '' }}</p>
                        @if(!empty($data['location']))
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 flex items-center gap-2">
                                <i class="bi bi-geo-alt-fill text-blue-500"></i> {{ $data['location'] }}
                            </p>
                        @endif
                        <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-8">
                            {{ $data['bio'] ?? '' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4 mb-8">
                        @php $githubHandle = $data['socials']['github'] ?? ($data['username'] ?? null); @endphp
                        @if($githubHandle)
                            <a href="https://github.com/{{ cleanHandle($githubHandle) }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2 px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200 text-lg">
                                <i class="bi bi-github"></i>
                                <span>GitHub</span>
                            </a>
                        @endif

                        @if(!empty($data['socials']['linkedin']))
                            <a href="{{ (strpos($data['socials']['linkedin'],'http') === 0) ? $data['socials']['linkedin'] : 'https://linkedin.com/in/' . cleanHandle($data['socials']['linkedin']) }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2 px-6 py-3 bg-blue-700 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 text-lg">
                                <i class="bi bi-linkedin"></i>
                                <span>LinkedIn</span>
                            </a>
                        @endif

                        @if(!empty($data['resume_url']))
                            <a href="{{ $data['resume_url'] }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200 text-lg">
                                <i class="bi bi-download"></i>
                                <span>Resume</span>
                            </a>
                        @endif

                        @if(!empty($data['socials']['twitter']))
                            <a href="https://twitter.com/{{ cleanHandle($data['socials']['twitter']) }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2 px-6 py-3 bg-blue-400 hover:bg-blue-300 text-white rounded-lg transition-colors duration-200 text-lg">
                                <i class="bi bi-twitter"></i>
                                <span>Twitter</span>
                            </a>
                        @endif

                        @if(!empty($data['socials']['personal_website']))
                            <a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 text-lg">
                                <i class="bi bi-globe"></i>
                                <span>Website</span>
                            </a>
                        @endif

                        @if(!empty($data['email']))
                            <a href="mailto:{{ $data['email'] ?? '' }}"
                               class="flex items-center space-x-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 text-lg">
                                <i class="bi bi-envelope-fill"></i>
                                <span>Email Me</span>
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <section id="about" class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-800">
                <div class="max-w-4xl mx-auto text-center scroll-reveal bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md">
                    <h2 class="text-4xl font-bold mb-6 text-blue-600 dark:text-blue-400">About Me</h2>
                    <div class="prose dark:prose-invert max-w-none text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($data['about_me'] ?? '')) !!}
                    </div>
                </div>
            </section>

            <section id="skills" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto scroll-reveal bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md">
                    <h2 class="text-4xl font-bold mb-8 text-center text-purple-600 dark:text-purple-400">Skills & Technologies</h2>
                    <div class="flex flex-wrap justify-center gap-3">
                        @if(!empty($data['skills']) && is_array($data['skills']))
                            @foreach($data['skills'] as $skill)
                                <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-md font-medium shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-lg">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-lg text-gray-600 dark:text-gray-400">No skills listed yet.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="experience" class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-800">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-4xl font-bold mb-12 text-center text-emerald-600 dark:text-emerald-400 scroll-reveal">Experience</h2>

                    <div class="space-y-8">
                        @if(!empty($data['experiences']) && is_array($data['experiences']))
                            @foreach($data['experiences'] as $experience)
                                <div class="bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md scroll-reveal transition-transform duration-300 hover:scale-[1.01]">
                                    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4 gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-50">{{ $experience['title'] ?? '' }}</h3>
                                            <p class="text-xl text-gray-700 dark:text-gray-300 mb-1">{{ $experience['company'] ?? '' }}</p>
                                            @if(!empty($experience['location']))
                                                <p class="text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                                    <i class="bi bi-geo-alt"></i> {{ $experience['location'] }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="mt-2 md:mt-0 flex-shrink-0">
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                <i class="bi bi-calendar3 mr-2"></i>
                                                {{ rangeLabel($experience['start_date'] ?? null, $experience['end_date'] ?? null) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(!empty($experience['description']))
                                        <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
                                            {{ $experience['description'] }}
                                        </p>
                                    @endif

                                    @if(!empty($experience['technologies']) && is_array($experience['technologies']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($experience['technologies'] as $tech)
                                                <span class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md text-sm">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-600 dark:text-gray-400 text-lg">No experience items.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="projects" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-4xl font-bold mb-12 text-center text-getmyname-600 dark:text-getmyname-400 scroll-reveal">Featured Projects</h2>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if(!empty($data['projects']) && is_array($data['projects']))
                            @foreach($data['projects'] as $project)
                                <article class="bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden scroll-reveal transition-transform duration-300 hover:scale-[1.02] hover:shadow-lg" role="article" aria-labelledby="proj-{{ $project['id'] ?? \Illuminate\Support\Str::random(6) }}">
                                    @if(!empty($project['image_path']))
                                        <div class="h-56 overflow-hidden">
                                            <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project image' }}" class="w-full h-full object-cover transform transition-transform duration-300 hover:scale-105" />
                                        </div>
                                    @endif

                                    <div class="p-6">
                                        <h3 id="proj-{{ $project['id'] ?? \Illuminate\Support\Str::random(6) }}" class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-50">{{ $project['title'] ?? $project['name'] ?? 'Untitled' }}</h3>

                                        @if(!empty($project['description']))
                                            <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed text-sm">{{ $project['description'] }}</p>
                                        @endif

                                        @if(!empty($project['tags']) && is_array($project['tags']))
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach($project['tags'] as $tag)
                                                    <span class="px-3 py-1 bg-getmyname-100 dark:bg-getmyname-900 text-getmyname-700 dark:text-getmyname-300 rounded-full text-xs">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(!empty($project['url']))
                                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 font-medium">
                                                <span>View Project</span>
                                                <i class="bi bi-arrow-up-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        @else
                            <p class="text-center text-gray-600 dark:text-gray-400 text-lg col-span-full">No projects to show.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="education" class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-800">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-4xl font-bold mb-12 text-center text-red-600 dark:text-red-400 scroll-reveal">Education</h2>

                    <div class="space-y-8">
                        @if(!empty($data['education']) && is_array($data['education']))
                            @foreach($data['education'] as $edu)
                                <div class="bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md scroll-reveal transition-transform duration-300 hover:scale-[1.01]">
                                    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-50">{{ $edu['school'] ?? ($edu['institution'] ?? '') }}</h3>
                                            <p class="text-xl text-gray-700 dark:text-gray-300 mb-1">{{ $edu['degree'] ?? '' }}</p>
                                            @if(!empty($edu['field_of_study']))
                                                <p class="text-gray-600 dark:text-gray-400">{{ $edu['field_of_study'] }}</p>
                                            @endif
                                        </div>

                                        <div class="mt-2 md:mt-0 flex-shrink-0">
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                <i class="bi bi-calendar3 mr-2"></i>
                                                {{ rangeLabel($edu['start_date'] ?? null, $edu['end_date'] ?? null) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(!empty($edu['description']))
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $edu['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-600 dark:text-gray-400 text-lg">No education entries.</p>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        <footer class="py-10 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto text-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    &copy; {{ date('Y') }} {{ $data['name'] ?? ($data['username'] ?? 'Profile') }}.
                    Powered by <a class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 underline" href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a>
                    from <a class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 underline" href="https://mtex.dev" target="_blank" rel="noopener noreferrer">mtex.dev</a>
                </p>
            </div>
        </footer>
    </div>

    <script>
        function themeManager() {
            return {
                theme: localStorage.getItem('theme') || 'system',

                init() {
                    this.updateTheme();

                    const mq = window.matchMedia('(prefers-color-scheme: dark)');
                    if (mq.addEventListener) {
                        mq.addEventListener('change', () => {
                            if (this.theme === 'system') this.updateTheme();
                        });
                    } else if (mq.addListener) {
                        mq.addListener(() => {
                            if (this.theme === 'system') this.updateTheme();
                        });
                    }

                    this.initScrollReveal();
                    this.initSmoothScroll();
                },

                setTheme(newTheme) {
                    this.theme = newTheme;
                    localStorage.setItem('theme', newTheme);
                    this.updateTheme();
                },

                updateTheme() {
                    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    const isDark = this.theme === 'dark' || (this.theme === 'system' && prefersDark);
                    document.documentElement.classList.toggle('dark', isDark);
                },

                initScrollReveal() {
                    const els = document.querySelectorAll('.scroll-reveal');
                    if (!els || els.length === 0) return;

                    if (!('IntersectionObserver' in window)) {
                        els.forEach(el => el.classList.add('revealed'));
                        return;
                    }

                    const observer = new IntersectionObserver((entries, obs) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('revealed');
                                obs.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

                    els.forEach(el => observer.observe(el));
                },

                initSmoothScroll() {
                    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                        anchor.addEventListener('click', function (e) {
                            const href = this.getAttribute('href');
                            if (!href || href === '#') return;
                            const target = document.querySelector(href);
                            if (target) {
                                e.preventDefault();
                                const offset = document.querySelector('nav').offsetHeight;
                                window.scrollTo({
                                    top: target.offsetTop - offset,
                                    behavior: 'smooth'
                                });
                                if (document.getElementById('mobile-menu').classList.contains('block')) {
                                    this.mobileOpen = false;
                                }
                            }
                        });
                    });
                }
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            const scrollRevealElements = document.querySelectorAll('.scroll-reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                rootMargin: '0px',
                threshold: 0.2
            });

            scrollRevealElements.forEach(el => observer.observe(el));
        });
    </script>
    <style>
        .scroll-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .scroll-reveal.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</body>
</html>