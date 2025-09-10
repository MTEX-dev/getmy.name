<!doctype html>
<html lang="en" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="{{ $data['name'] ?? '' }} — {{ $data['title'] ?? '' }}">

    <title>{{ $data['name'] ?? 'Profile' }} — {{ $data['title'] ?? '' }}</title>

    {{-- Prevent flash of wrong theme: apply early based on localStorage or system preference --}}
    <script>
        (function(){
            try {
                var key = 'theme';
                var pref = localStorage.getItem(key);
                if(pref === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if(pref === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    // system or unknown
                    if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            } catch (e) { /* ignore */ }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900 dark:bg-slate-900 dark:text-slate-100 transition-colors duration-200">

    @php
        // small date formatter helper (uses Carbon if available)
        if (! function_exists('fmtDate')) {
            function fmtDate($date) {
                if (empty($date)) return '';
                try {
                    return \Carbon\Carbon::parse($date)->format('M Y');
                } catch (\Throwable $e) {
                    return $date;
                }
            }
        }
    @endphp

    <header class="border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="text-lg font-semibold leading-none">{{ $data['name'] ?? '' }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $data['title'] ?? '' }}</div>
            </div>

            <div class="flex items-center gap-4">
                {{-- Social icons --}}
                <nav class="flex items-center gap-2" aria-label="Social links">
                    @php $socials = $data['socials'] ?? []; @endphp

                    @if(!empty($socials['github']))
                        <a href="https://github.com/{{ $socials['github'] }}" target="_blank" rel="noopener" class="p-2 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="GitHub">
                            {{-- GitHub Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5C5.73.5.5 5.73.5 12c0 5.08 3.29 9.39 7.86 10.91.57.1.78-.25.78-.55 0-.27-.01-1-.02-1.96-3.2.7-3.88-1.54-3.88-1.54-.52-1.32-1.27-1.67-1.27-1.67-1.04-.72.08-.7.08-.7 1.15.08 1.76 1.18 1.76 1.18 1.02 1.75 2.68 1.24 3.33.95.1-.74.4-1.24.72-1.53-2.55-.29-5.23-1.28-5.23-5.7 0-1.26.45-2.29 1.18-3.1-.12-.29-.51-1.46.11-3.04 0 0 .96-.31 3.14 1.18A10.94 10.94 0 0 1 12 6.84c.97.01 1.95.13 2.86.38 2.18-1.49 3.14-1.18 3.14-1.18.62 1.58.23 2.75.11 3.04.74.81 1.18 1.84 1.18 3.1 0 4.43-2.69 5.4-5.25 5.68.41.35.77 1.04.77 2.1 0 1.52-.01 2.75-.01 3.13 0 .3.2.66.79.55A11.51 11.51 0 0 0 23.5 12C23.5 5.73 18.27.5 12 .5z"/></svg>
                        </a>
                    @endif

                    @if(!empty($socials['linkedin']))
                        <a href="{{ $socials['linkedin'] }}" target="_blank" rel="noopener" class="p-2 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="LinkedIn">
                            {{-- LinkedIn Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5C3.88 3.5 3 4.38 3 5.48c0 1.1.88 1.98 1.98 1.98h.02C6.08 7.46 7 6.58 7 5.48 7 4.38 6.08 3.5 4.98 3.5zM3.5 8.98h3v11.52h-3V8.98zM9.5 8.98h2.86v1.6h.04c.4-.76 1.38-1.56 2.84-1.56 3.04 0 3.6 2 3.6 4.6v6.88h-3V15.9c0-1.24-.02-2.84-1.74-2.84-1.74 0-2 1.34-2 2.74v6.68h-3V8.98z"/></svg>
                        </a>
                    @endif

                    @if(!empty($socials['twitter']))
                        <a href="https://twitter.com/{{ $socials['twitter'] }}" target="_blank" rel="noopener" class="p-2 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="Twitter">
                            {{-- Twitter Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.32 4.32 0 0 0 1.9-2.38 8.59 8.59 0 0 1-2.72 1.04A4.28 4.28 0 0 0 12 8.77c0 .34.04.67.11.99A12.12 12.12 0 0 1 3.16 5.15a4.28 4.28 0 0 0 1.33 5.71c-.64-.02-1.24-.2-1.77-.5v.05c0 2.08 1.48 3.82 3.44 4.22-.36.1-.73.14-1.12.14-.27 0-.54-.03-.8-.07.54 1.68 2.1 2.9 3.95 2.94A8.58 8.58 0 0 1 2 19.54a12.12 12.12 0 0 0 6.56 1.92c7.88 0 12.2-6.53 12.2-12.2v-.56A8.7 8.7 0 0 0 22.46 6z"/></svg>
                        </a>
                    @endif

                    @if(!empty($socials['personal_website']))
                        <a href="{{ $socials['personal_website'] }}" target="_blank" rel="noopener" class="p-2 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="Website">
                            {{-- Link Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3.9 12a5 5 0 0 1 0-7.07l2.12-2.12a5 5 0 0 1 7.07 7.07L11 11.1a1 1 0 0 1-1.41-1.42l1.1-1.1a3 3 0 0 0-4.24-4.24L3.9 5.66a3 3 0 0 0 0 4.24L5 10.99a1 1 0 1 1-1.41 1.41L3.9 12zM20.1 12a5 5 0 0 1 0 7.07l-2.12 2.12a5 5 0 0 1-7.07-7.07L13 12.9a1 1 0 0 1 1.41 1.42l-1.1 1.1a3 3 0 0 0 4.24 4.24l2.12-2.12a3 3 0 0 0 0-4.24L19 13.01a1 1 0 0 1 1.41-1.41L20.1 12z"/></svg>
                        </a>
                    @endif
                </nav>

                {{-- Theme switcher: system | dark | light --}}
                <div class="flex items-center border rounded-lg overflow-hidden bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700">
                    <button type="button" data-theme-option="system" class="px-3 py-2 text-xs leading-none hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none" aria-pressed="false" title="System preference">System</button>
                    <button type="button" data-theme-option="dark" class="px-3 py-2 text-xs leading-none hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none" aria-pressed="false" title="Dark mode">Dark</button>
                    <button type="button" data-theme-option="light" class="px-3 py-2 text-xs leading-none hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none" aria-pressed="false" title="Light mode">Light</button>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
            <div class="flex items-center justify-center md:justify-start">
                <div class="text-center md:text-left">
                    <div class="mx-auto md:mx-0 w-36 h-36 rounded-full overflow-hidden shadow-md ring-4 ring-white dark:ring-slate-800">
                        <img src="{{ $data['avatar_url'] ?? '' }}" alt="{{ $data['name'] ?? 'Avatar' }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $data['name'] ?? '' }}</h1>
                <p class="mt-1 text-lg text-slate-600 dark:text-slate-300">{{ $data['title'] ?? '' }}</p>

                <div class="mt-4 text-slate-700 dark:text-slate-300 max-w-2xl">
                    <p>{{ $data['bio'] ?? '' }}</p>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    @if(!empty($data['location']))
                        <div class="inline-flex items-center text-sm text-slate-600 dark:text-slate-400 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                            <span>{{ $data['location'] }}</span>
                        </div>
                    @endif

                    <a href="mailto:{{ $data['email'] ?? '' }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium bg-sky-600 text-white hover:bg-sky-700 transition">Contact Me</a>
                </div>
            </div>
        </section>

        {{-- About Me --}}
        <section class="mt-12">
            <h2 class="text-2xl font-semibold">About Me</h2>
            <div class="mt-3 text-slate-700 dark:text-slate-300 leading-relaxed max-w-3xl">
                {!! nl2br(e($data['about_me'] ?? '')) !!}
            </div>
        </section>

        {{-- Skills --}}
        <section class="mt-12">
            <h2 class="text-2xl font-semibold">Skills</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($data['skills'] ?? [] as $skill)
                    <span class="px-3 py-1 text-sm bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full">{{ $skill }}</span>
                @endforeach
            </div>
        </section>

        {{-- Projects --}}
        <section class="mt-12">
            <h2 class="text-2xl font-semibold">Projects</h2>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($data['projects'] ?? [] as $project)
                    <article class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        @if(!empty($project['image_path']))
                            <div class="h-40 w-full overflow-hidden">
                                <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-40 w-full flex items-center justify-center bg-slate-50 dark:bg-slate-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 3v4M16 3v4M4 11h16"/></svg>
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="font-semibold text-lg truncate">{{ $project['title'] ?? $project['name'] ?? 'Untitled' }}</h3>
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $project['description'] ?? '' }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ $project['url'] ?? '#' }}" target="_blank" rel="noopener" class="text-sm font-medium text-sky-600 dark:text-sky-400 hover:underline">Visit</a>
                                <span class="text-xs text-slate-400">ID: {{ $project['id'] ?? '' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- Experience --}}
        <section class="mt-12">
            <h2 class="text-2xl font-semibold">Experience</h2>
            <div class="mt-6 space-y-6">
                @foreach($data['experiences'] ?? [] as $exp)
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-lg font-semibold">{{ $exp['title'] ?? '' }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $exp['company'] ?? '' }} @if(!empty($exp['location'])) · <span class="">{{ $exp['location'] }}</span>@endif</div>
                            </div>
                            <div class="text-sm text-slate-500 dark:text-slate-400 text-right">
                                <div>{{ fmtDate($exp['start_date'] ?? '') }} — {{ fmtDate($exp['end_date'] ?? '') }}</div>
                            </div>
                        </div>

                        @if(!empty($exp['description']))
                            <div class="mt-3 text-slate-700 dark:text-slate-300">{{ $exp['description'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Education --}}
        <section class="mt-12">
            <h2 class="text-2xl font-semibold">Education</h2>
            <div class="mt-6 space-y-4">
                @foreach($data['education'] ?? [] as $edu)
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">{{ $edu['school'] ?? '' }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $edu['degree'] ?? '' }} · {{ $edu['field_of_study'] ?? '' }}</div>
                            </div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ fmtDate($edu['start_date'] ?? '') }} — {{ fmtDate($edu['end_date'] ?? '') }}</div>
                        </div>

                        @if(!empty($edu['description']))
                            <div class="mt-3 text-slate-700 dark:text-slate-300">{{ $edu['description'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

    </main>

    <footer class="border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
            <div>Powered by <a href="https://getmy.name" target="_blank" rel="noopener" class="hover:underline">getmy.name</a> from <a href="https://mtex.dev" target="_blank" rel="noopener" class="hover:underline">mtex.dev</a></div>
            <div class="text-right">API calls: <span class="font-medium text-slate-700 dark:text-slate-200">{{ $data['api_request_count'] ?? 0 }}</span></div>
        </div>
    </footer>

    {{-- Theme switcher behavior script --}}
    <script>
        (function(){
            const key = 'theme';
            const buttons = document.querySelectorAll('[data-theme-option]');

            function applyTheme(pref) {
                const root = document.documentElement;
                if(pref === 'dark') {
                    root.classList.add('dark');
                } else if(pref === 'light') {
                    root.classList.remove('dark');
                } else {
                    // system: follow OS
                    if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        root.classList.add('dark');
                    } else {
                        root.classList.remove('dark');
                    }
                }
                // update aria-pressed and active styles
                buttons.forEach(btn => {
                    const isActive = btn.dataset.themeOption === pref;
                    btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                    if(isActive) {
                        btn.classList.add('bg-slate-200', 'dark:bg-slate-700');
                    } else {
                        btn.classList.remove('bg-slate-200', 'dark:bg-slate-700');
                    }
                });
            }

            function init() {
                const pref = localStorage.getItem(key) || 'system';
                applyTheme(pref);

                buttons.forEach(btn => {
                    btn.addEventListener('click', function(){
                        const p = this.dataset.themeOption;
                        localStorage.setItem(key, p);
                        applyTheme(p);
                    });
                });

                // react to system changes only when pref === 'system'
                if(window.matchMedia) {
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if((localStorage.getItem(key) || 'system') === 'system') {
                            applyTheme('system');
                        }
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', init);
        })();
    </script>
</body>
</html>
