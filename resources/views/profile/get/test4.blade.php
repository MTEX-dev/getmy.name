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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root { --nav-height: 72px; }

        .nebula-gradient {
            background: linear-gradient(135deg,
                rgba(59, 130, 246, 0.08) 0%,
                rgba(147, 51, 234, 0.06) 25%,
                rgba(236, 72, 153, 0.06) 50%,
                rgba(245, 158, 11, 0.06) 75%,
                rgba(34, 197, 94, 0.06) 100%
            );
            position: fixed;
            inset: 0;
            z-index: -1;
        }

        .floating-card {
            backdrop-filter: blur(8px);
            background: rgba(255,255,255,0.85);
            border: 1px solid rgba(255,255,255,0.16);
        }

        .dark .floating-card {
            background: rgba(17,24,39,0.7);
            border: 1px solid rgba(75,85,99,0.28);
        }

        .skill-tag { transition: all 0.25s ease; transform: translateY(0); }
        .skill-tag:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }

        .project-card { transition: transform 0.35s cubic-bezier(0.2,0.8,0.2,1); }
        .project-card:hover { transform: translateY(-8px); }

        .scroll-reveal { opacity: 0; transform: translateY(24px); transition: all 0.6s ease-out; }
        .scroll-reveal.revealed { opacity: 1; transform: translateY(0); }

        .theme-btn {
            padding: .45rem .6rem;
            border-radius: .5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            color: #4a5568;
        }
        .dark .theme-btn {
            color: #d1d5db;
        }

        .theme-btn.active {
            background-color: #e2e8f0;
            color: #2d3748;
        }
        .dark .theme-btn.active {
            background-color: #4a5568;
            color: #e2e8f0;
        }

        main { padding-top: calc(var(--nav-height) + 1rem); }

        a:focus { outline: 3px solid rgba(59,130,246,0.25); outline-offset: 2px; }
    </style>
</head>

<body class="font-inter bg-gradient-to-br from-slate-50 via-blue-50 to-getmyname-50 dark:from-gray-900 dark:via-blue-900 dark:to-getmyname-900 text-gray-900 dark:text-white transition-all duration-500">
    <div class="nebula-gradient" aria-hidden="true"></div>

    <div class="relative z-10">
        <nav role="navigation" class="fixed top-0 left-0 right-0 z-50 floating-card border-b border-white/20 dark:border-gray-700/30" style="height:var(--nav-height);" x-data="{ mobileOpen: false }">
            <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="#top" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ explode(' ', $data['name'] ?? '')[0] ?? ($data['username'] ?? 'Profile') }}
                    </a>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="#about" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">About</a>
                        <a href="#experience" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Experience</a>
                        <a href="#projects" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Projects</a>
                        <a href="#education" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Education</a>
                        <a href="#contact" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Contact</a>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex bg-gray-100 dark:bg-gray-800 rounded-lg p-1" role="tablist" aria-label="Theme switcher">
                        <button @click="setTheme('light')" :class="theme === 'light' ? 'theme-btn active' : 'theme-btn'" class="p-2 rounded-md transition-all duration-200 text-sm" aria-pressed="false" title="Light">
                            <i class="bi bi-sun-fill" aria-hidden="true"></i>
                        </button>
                        <button @click="setTheme('system')" :class="theme === 'system' ? 'theme-btn active' : 'theme-btn'" class="p-2 rounded-md transition-all duration-200 text-sm" title="System">
                            <i class="bi bi-circle-half" aria-hidden="true"></i>
                        </button>
                        <button @click="setTheme('dark')" :class="theme === 'dark' ? 'theme-btn active' : 'theme-btn'" class="p-2 rounded-md transition-all duration-200 text-sm" title="Dark">
                            <i class="bi bi-moon-stars-fill" aria-hidden="true"></i>
                        </button>
                    </div>

                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-white/20 transition-colors duration-200" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle menu">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" x-show="mobileOpen" x-transition class="md:hidden py-4 border-t border-white/20 dark:border-gray-700/30">
                <div class="flex flex-col space-y-3 px-4">
                    <a href="#about" @click="mobileOpen = false" class="py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">About</a>
                    <a href="#experience" @click="mobileOpen = false" class="py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Experience</a>
                    <a href="#projects" @click="mobileOpen = false" class="py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Projects</a>
                    <a href="#education" @click="mobileOpen = false" class="py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Education</a>
                    <a href="#contact" @click="mobileOpen = false" class="py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Contact</a>
                </div>
            </div>
        </nav>

        <main id="top" class="min-h-screen">
            <section class="pt-8 pb-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div class="scroll-reveal">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-20 h-20 rounded-full overflow-hidden ring-4 ring-white/50 dark:ring-gray-700/50">
                                    <img src="{{ $data['avatar_url'] ?? '' }}" alt="{{ $data['name'] ?? 'Avatar' }}" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                                            {{ $data['name'] ?? ($data['username'] ?? 'Unnamed') }}
                                        </span>
                                    </h1>
                                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">{{ $data['title'] ?? '' }}</p>
                                    @if(!empty($data['location']))
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $data['location'] }}</p>
                                    @endif
                                </div>
                            </div>

                            <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                                {{ $data['bio'] ?? '' }}
                            </p>

                            <div class="flex flex-wrap gap-3 mb-6">
                                @php $githubHandle = $data['socials']['github'] ?? ($data['username'] ?? null); @endphp
                                @if($githubHandle)
                                    <a href="https://github.com/{{ cleanHandle($githubHandle) }}" target="_blank" rel="noopener noreferrer"
                                       class="flex items-center space-x-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition-colors duration-200">
                                        <i class="bi bi-github"></i>
                                        <span>GitHub</span>
                                    </a>
                                @endif

                                @if(!empty($data['socials']['linkedin']))
                                    <a href="{{ (strpos($data['socials']['linkedin'],'http') === 0) ? $data['socials']['linkedin'] : 'https://linkedin.com/in/' . cleanHandle($data['socials']['linkedin']) }}" target="_blank" rel="noopener noreferrer"
                                       class="flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                        <i class="bi bi-linkedin"></i>
                                        <span>LinkedIn</span>
                                    </a>
                                @endif

                                @if(!empty($data['resume_url']))
                                    <a href="{{ $data['resume_url'] }}" target="_blank" rel="noopener noreferrer"
                                       class="flex items-center space-x-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200">
                                        <i class="bi bi-download"></i>
                                        <span>Resume</span>
                                    </a>
                                @endif

                                @if(!empty($data['socials']['twitter']))
                                    <a href="https://twitter.com/{{ cleanHandle($data['socials']['twitter']) }}" target="_blank" rel="noopener noreferrer"
                                       class="flex items-center space-x-2 px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-colors duration-200">
                                        <i class="bi bi-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                @endif

                                @if(!empty($data['socials']['personal_website']))
                                    <a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener noreferrer"
                                       class="flex items-center space-x-2 px-4 py-2 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-100 rounded-lg transition-colors duration-200">
                                        <i class="bi bi-globe"></i>
                                        <span>Website</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="scroll-reveal">
                            <div class="floating-card rounded-2xl p-8">
                                <h3 class="text-2xl font-semibold mb-6 flex items-center">
                                    <i class="bi bi-code-slash text-blue-600 mr-3"></i> Skills & Technologies
                                </h3>

                                <div class="flex flex-wrap gap-3">
                                    @if(!empty($data['skills']) && is_array($data['skills']))
                                        @foreach($data['skills'] as $skill)
                                            <span class="skill-tag px-4 py-2 bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-200/30 dark:border-blue-700/30 rounded-lg text-sm font-medium">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No skills listed yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="about" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="floating-card rounded-2xl p-8 lg:p-12 scroll-reveal">
                        <h2 class="text-3xl lg:text-4xl font-bold mb-6 text-center">
                            <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">About Me</span>
                        </h2>
                        <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 dark:text-gray-300">
                            <p class="text-center leading-relaxed">
                                {!! nl2br(e($data['about_me'] ?? '')) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="experience" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-12 text-center scroll-reveal">
                        <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Experience</span>
                    </h2>

                    <div class="space-y-8">
                        @if(!empty($data['experiences']) && is_array($data['experiences']))
                            @foreach($data['experiences'] as $experience)
                                <div class="floating-card rounded-2xl p-8 scroll-reveal">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4 gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-semibold text-blue-600 dark:text-blue-400">{{ $experience['title'] ?? '' }}</h3>
                                            <p class="text-xl font-medium text-gray-800 dark:text-gray-200">{{ $experience['company'] ?? '' }}</p>
                                            @if(!empty($experience['location']))
                                                <p class="text-gray-600 dark:text-gray-400">{{ $experience['location'] }}</p>
                                            @endif
                                        </div>

                                        <div class="mt-2 lg:mt-0">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                <i class="bi bi-calendar3 mr-1"></i>
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
                                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md text-sm">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">No experience items.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="projects" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-12 text-center scroll-reveal">
                        <span class="bg-gradient-to-r from-pink-600 to-orange-600 bg-clip-text text-transparent">Featured Projects</span>
                    </h2>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if(!empty($data['projects']) && is_array($data['projects']))
                            @foreach($data['projects'] as $project)
                                <article class="project-card floating-card rounded-2xl overflow-hidden scroll-reveal" role="article" aria-labelledby="proj-{{ $project['id'] ?? \Illuminate\Support\Str::random(6) }}">
                                    @if(!empty($project['image_path']))
                                        <div class="h-48 overflow-hidden">
                                            <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project image' }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
                                        </div>
                                    @endif

                                    <div class="p-6">
                                        <h3 id="proj-{{ $project['id'] ?? \Illuminate\Support\Str::random(6) }}" class="text-xl font-semibold mb-3 text-blue-600 dark:text-blue-400">{{ $project['title'] ?? $project['name'] ?? 'Untitled' }}</h3>

                                        @if(!empty($project['description']))
                                            <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ $project['description'] }}</p>
                                        @endif

                                        @if(!empty($project['tags']) && is_array($project['tags']))
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach($project['tags'] as $tag)
                                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(!empty($project['url']))
                                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                                                <span>View Project</span>
                                                <i class="bi bi-arrow-up-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">No projects to show.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="education" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-12 text-center scroll-reveal">
                        <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">Education</span>
                    </h2>

                    <div class="space-y-8">
                        @if(!empty($data['education']) && is_array($data['education']))
                            @foreach($data['education'] as $edu)
                                <div class="floating-card rounded-2xl p-8 scroll-reveal">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-semibold text-orange-600 dark:text-orange-400">{{ $edu['school'] ?? ($edu['institution'] ?? '') }}</h3>
                                            <p class="text-xl font-medium text-gray-800 dark:text-gray-200">{{ $edu['degree'] ?? '' }}</p>
                                            @if(!empty($edu['field_of_study']))
                                                <p class="text-gray-600 dark:text-gray-400">{{ $edu['field_of_study'] }}</p>
                                            @endif
                                        </div>

                                        <div class="mt-2 lg:mt-0">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                                <i class="bi bi-calendar3 mr-1"></i>
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
                            <p class="text-center text-gray-500 dark:text-gray-400">No education entries.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="contact" class="py-16 px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center">
                    <div class="floating-card rounded-2xl p-8 lg:p-12 scroll-reveal">
                        <h2 class="text-3xl lg:text-4xl font-bold mb-6">
                            <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Get In Touch</span>
                        </h2>

                        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
                            I'm always open to discussing new opportunities, interesting projects, or just having a chat about technology.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="mailto:{{ $data['email'] ?? '' }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105">
                                <i class="bi bi-envelope-fill"></i>
                                <span>Send Email</span>
                            </a>

                            @if(!empty($data['socials']['personal_website']))
                                <a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-2 px-6 py-3 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 transform hover:scale-105">
                                    <i class="bi bi-globe"></i>
                                    <span>Visit Website</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="py-12 px-4 sm:px-6 lg:px-8 border-t border-white/20 dark:border-gray-700/30">
            <div class="max-w-7xl mx-auto text-center">
                <div class="floating-card rounded-2xl p-8">
                    <p class="text-gray-600 dark:text-gray-400">
                        &copy; {{ date('Y') }} {{ $data['name'] ?? ($data['username'] ?? 'Profile') }}.
                        Powered by <a class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 underline" href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a>
                        from <a class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 underline" href="https://mtex.dev" target="_blank" rel="noopener noreferrer">mtex.dev</a>
                    </p>
                </div>
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
                    }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });

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
                                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                try { if (document.querySelector('[x-data]') && window.Alpine) { } } catch(e) {}
                            }
                        });
                    });
                }
            };
        }
    </script>

</body>
</html>