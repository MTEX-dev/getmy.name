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

        a:focus { outline: 3px solid rgba(59,130,246,0.25); outline-offset: 2px; }
    </style>
</head>

<body class="font-inter bg-gradient-to-br from-slate-50 via-blue-50 to-getmyname-50 dark:from-gray-900 dark:via-blue-900 dark:to-getmyname-900 text-gray-900 dark:text-white transition-all duration-500">
    <div class="nebula-gradient" aria-hidden="true"></div>

    <div class="relative z-10 min-h-screen flex flex-col">
        <header class="w-full py-4 px-4 sm:px-6 lg:px-8 floating-card border-b border-white/20 dark:border-gray-700/30">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <a href="/" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ explode(' ', $data['name'] ?? '')[0] ?? ($data['username'] ?? 'Profile') }}
                </a>
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
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div class="max-w-4xl w-full">
                <div class="floating-card rounded-2xl p-8 lg:p-12 text-center scroll-reveal">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden ring-4 ring-white/50 dark:ring-gray-700/50 mb-6">
                        <img src="{{ $data['avatar_url'] ?? '' }}" alt="{{ $data['name'] ?? 'Avatar' }}" class="w-full h-full object-cover" />
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-2">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                            {{ $data['name'] ?? ($data['username'] ?? 'Unnamed') }}
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-4">{{ $data['title'] ?? '' }}</p>
                    @if(!empty($data['location']))
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $data['location'] }}</p>
                    @endif

                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-8">
                        {{ $data['bio'] ?? '' }}
                    </p>

                    <div class="flex flex-wrap gap-4 justify-center">
                        @php $githubHandle = $data['socials']['github'] ?? ($data['username'] ?? null); @endphp
                        @if($githubHandle)
                            <a href="https://github.com/{{ cleanHandle($githubHandle) }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center space-x-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition-colors duration-200 transform hover:scale-105">
                                <i class="bi bi-github"></i>
                                <span>GitHub</span>
                            </a>
                        @endif

                        @if(!empty($data['socials']['linkedin']))
                            <a href="{{ (strpos($data['socials']['linkedin'],'http') === 0) ? $data['socials']['linkedin'] : 'https://linkedin.com/in/' . cleanHandle($data['socials']['linkedin']) }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center space-x-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 transform hover:scale-105">
                                <i class="bi bi-linkedin"></i>
                                <span>LinkedIn</span>
                            </a>
                        @endif

                        @if(!empty($data['resume_url']))
                            <a href="{{ $data['resume_url'] }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center space-x-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200 transform hover:scale-105">
                                <i class="bi bi-download"></i>
                                <span>Resume</span>
                            </a>
                        @endif

                        @if(!empty($data['socials']['twitter']))
                            <a href="https://twitter.com/{{ cleanHandle($data['socials']['twitter']) }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center space-x-2 px-5 py-2.5 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-colors duration-200 transform hover:scale-105">
                                <i class="bi bi-twitter"></i>
                                <span>Twitter</span>
                            </a>
                        @endif

                        @if(!empty($data['socials']['personal_website']))
                            <a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center space-x-2 px-5 py-2.5 border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 transform hover:scale-105">
                                <i class="bi bi-globe"></i>
                                <span>Website</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-8 px-4 sm:px-6 lg:px-8 border-t border-white/20 dark:border-gray-700/30">
            <div class="max-w-7xl mx-auto text-center">
                <div class="floating-card rounded-2xl p-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
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
                }
            };
        }
    </script>
</body>
</html>