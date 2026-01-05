@php
    $get = fn($key, $default = null) => data_get($data, $key, $default);

    $formatDate = function ($date, $current = false) {
        if (!$date && $current) return 'Present';
        if (!$date) return null;
        try {
            return \Carbon\Carbon::parse($date)->format('M Y');
        } catch (\Throwable $e) {
            return $date;
        }
    };
    
    $socials = [
        'github' => [
            'svg' => '<path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>',
            'label' => 'GitHub',
            'prefix' => 'https://github.com/',
        ],
        'linkedin' => [
            'svg' => '<path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>',
            'label' => 'LinkedIn',
            'prefix' => 'https://www.linkedin.com/in/',
        ],
        'twitter' => [
            'svg' => '<path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>',
            'label' => 'X',
            'prefix' => 'https://x.com/',
        ],
        'bluesky' => [
            'svg' => '<path d="M12 10.8c-1.324-1.896-4.602-5.493-7.861-6.156C2.779 4.369 0 5.645 0 8.073c0 1.474.59 3.372 1.846 4.937.45.557.94 1.076 1.277 1.419-.738 1.236-1.554 3.13-1.554 4.886 0 3.332 1.492 5.23 5.631 5.481 2.24.135 3.388-1.298 4.793-2.79.141-.141.282-.282.427-.419.145.137.286.278.427.419 1.405 1.492 2.553 2.925 4.793 2.79 4.139-.251 5.631-2.149 5.631-5.481 0-1.756-.816-3.65-1.554-4.886.337-.343.827-.862 1.277-1.419C23.41 11.445 24 9.547 24 8.073c0-2.428-2.779-3.704-4.139-3.429-3.259.663-6.537 4.26-7.861 6.156Z"/>',
            'label' => 'Bluesky',
            'prefix' => 'https://bsky.app/profile/',
        ],
        'personal_website' => [
            'svg' => '<path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1 14.808l-2.072-1.382c-.105-.07-.128-.213-.053-.311l.972-1.296c.074-.099.215-.121.316-.048l1.411 1.03 2.502-3.13c.092-.114.256-.129.367-.033l1.1 0.941c.11.096.126.26.035.374l-3.9 4.875c-.131.164-.378.163-.507-.02l-.171-.2z"/>',
            'label' => 'Website',
            'prefix' => '',
        ],
        'codepen' => [
            'svg' => '<path d="M24 8.247v7.506c0 .265-.117.514-.321.683l-10.957 8.441c-.2.155-.457.234-.722.234s-.522-.079-.722-.234L.321 16.436c-.204-.169-.321-.418-.321-.683V8.247c0-.265.117-.514.321-.683L10.957.321c.4-.308 1.043-.308 1.444 0l10.957 7.243c.204.169.321.418.321.683zm-11.278 12.01l8.531-6.136-3.791-2.548-4.74 3.197v5.487zm-1.444 0v-5.487l-4.74-3.197-3.791 2.548 8.531 6.136zm0-7.394l3.522-2.378-3.522-2.355-3.522 2.355 3.522 2.378zm11.278-4.102l-3.868 2.6-3.868-2.6 3.868-2.6 3.868 2.6zm-18.688 0l3.868 2.6 3.868-2.6-3.868-2.6-3.868 2.6zm7.41-3.618l-8.531 6.136 3.791 2.548 4.74-3.197V3.143zm1.444 0v5.487l4.74 3.197 3.791-2.548-8.531-6.136z"/>',
            'label' => 'CodePen',
            'prefix' => 'https://codepen.io/',
        ],
        'instagram' => [
            'svg' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>',
            'label' => 'Instagram',
            'prefix' => 'https://www.instagram.com/',
        ],
        'youtube_url' => [
            'svg' => '<path d="M23.498 6.186c-.275-1.031-1.082-1.838-2.113-2.113C19.518 3.545 12 3.545 12 3.545s-7.518 0-9.385.528c-1.031.275-1.838 1.082-2.113 2.113C0 8.053 0 12 0 12s0 3.947.502 5.814c.275 1.03 1.082 1.837 2.113 2.113C4.482 20.455 12 20.455 12 20.455s7.518 0 9.385-.528c1.03-.276 1.837-1.083 2.113-2.113C24 15.947 24 12 24 12s0-3.947-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>',
            'label' => 'YouTube',
            'prefix' => '',
        ],
        'stackoverflow' => [
            'svg' => '<path d="M18.986 21.867v-6.404h2.155v8.551H.871v-8.551h2.155v6.404h15.96zM7.067 14.768l.983-1.909 9.544 4.912-.983 1.909-9.544-4.912zm2.396-4.423l1.415-1.618 8.21 7.19-1.415 1.618-8.21-7.19zm3.39-3.623l1.737-1.255 6.46 8.79-1.737 1.255-6.46-8.79zm4.253-2.521l1.962-.872 4.364 9.84-1.962.872-4.364-9.84zM5.99 18.232H16.14v2.155H5.99v-2.155z"/>',
            'label' => 'Stack Overflow',
            'prefix' => 'https://stackoverflow.com/users/',
        ],
        'dev_to' => [
            'svg' => '<path d="M7.42 10.05c-.18-.16-.46-.23-.84-.23H6l.02 4.42h.66c.51 0 .88-.13 1.11-.39.22-.26.33-.6.33-1.05v-1.7c0-.46-.1-.81-.3-1.05zM24 12c0 6.627-5.373 12-12 12S0 18.627 0 12 5.373 0 12 0s12 5.373 12 12zm-14.59 4.14a3.35 3.35 0 0 0 1.16-.31 2.3 2.3 0 0 0 .84-.73 2.5 2.5 0 0 0 .42-1.02c.08-.43.12-.83.12-1.2V11c0-.37-.04-.77-.12-1.2a2.5 2.5 0 0 0-.42-1.02 2.3 2.3 0 0 0-.84-.73 3.35 3.35 0 0 0-1.16-.31c-.41-.02-1.24-.02-1.43-.02H4v7.46h1.98c.19 0 1.02 0 1.43-.02zM15 8.54h-1.47v7.46H15v-2.45h1.16v-1.5H15V10h1.56V8.54H15zm5.54 0h-1.33L18 10.51l-1.21-1.97H15.4l2 3.2v4.29h1.34v-4.29l2-3.21z"/>',
            'label' => 'DEV',
            'prefix' => 'https://dev.to/',
        ],
        'hashnode' => [
            'svg' => '<path d="M22.351 8.019l-6.37-6.37a5.63 5.63 0 0 0-7.962 0l-6.37 6.37a5.63 5.63 0 0 0 0 7.962l6.37 6.37a5.63 5.63 0 0 0 7.962 0l6.37-6.37a5.63 5.63 0 0 0 0-7.962zM12 15.953a3.953 3.953 0 1 1 0-7.906 3.953 3.953 0 0 1 0 7.906z"/>',
            'label' => 'Hashnode',
            'prefix' => 'https://hashnode.com/@',
        ],
        'npm' => [
            'svg' => '<path d="M1.493 0v24h21.014V0H1.493zM5.96 21.037H3.985v-18.06h16.03v18.06h-3.986V7.485h-4.015v13.552H5.96v.001z"/>',
            'label' => 'npm',
            'prefix' => 'https://www.npmjs.com/~',
        ],
        'product_hunt' => [
            'svg' => '<path d="M13.56 12.348h-2.31V9.112h2.31c.893 0 1.617.724 1.617 1.618s-.724 1.618-1.617 1.618zM24 12c0 6.627-5.373 12-12 12S0 18.627 0 12 5.373 0 12 0s12 5.373 12 12zm-8.823-3.618H10.125v7.551h1.125v-2.398h2.31c2.109 0 3.817-1.709 3.817-3.818s-1.708-3.817-3.817-3.817z"/>',
            'label' => 'Product Hunt',
            'prefix' => 'https://www.producthunt.com/@',
        ],
        'polywork' => [
            'svg' => '<path d="M19.125 0H4.875A4.875 4.875 0 0 0 0 4.875v14.25A4.875 4.875 0 0 0 4.875 24h14.25A4.875 4.875 0 0 0 24 19.125V4.875A4.875 4.875 0 0 0 19.125 0zM12 17.5a5.5 5.5 0 1 1 5.5-5.5 5.5 5.5 0 0 1-5.5 5.5z"/>',
            'label' => 'Polywork',
            'prefix' => 'https://www.polywork.com/',
        ],
        'gitlab' => [
            'svg' => '<path d="M23.955 13.587l-1.342-4.135-2.664-8.189c-.135-.417-.724-.417-.859 0L16.425 9.45H7.574L4.911 1.263c-.135-.417-.724-.417-.859 0L1.387 9.45.045 13.587c-.114.351.015.738.317.957l11.638 8.448 11.638-8.448c.302-.219.431-.606.317-.957z"/>',
            'label' => 'GitLab',
            'prefix' => 'https://gitlab.com/',
        ],
        'dribbble' => [
            'svg' => '<path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-1.79-.53-3.646-.243a11.367 11.367 0 0 1 2.088 6.003 10.212 10.212 0 0 0 1.558-5.76zM19.08 21.23a9.637 9.637 0 0 0-2.131-5.732c-.07.068-.137.14-.203.208-2.1 2.11-4.887 4.966-5.482 9.564a10.222 10.222 0 0 0 7.816-4.04zM8.344 23.224c.614-4.535 3.1-7.14 5.216-9.261l.174-.174c-.453-1.19-.97-2.408-1.536-3.605-4.31 1.315-9.339 1.32-9.669 1.32-.03.41-.048.826-.048 1.246a10.224 10.224 0 0 0 5.863 10.474zM2.512 10.11c.31.003 4.478.019 8.52-1.032a14.85 14.85 0 0 0-3.375-5.915 10.227 10.227 0 0 0-5.145 6.947zm7.33-7.234a12.87 12.87 0 0 1 3.535 6.046 14.546 14.546 0 0 0 6.284-3.728A10.171 10.171 0 0 0 12 1.776a10.124 10.124 0 0 0-2.158 1.1zM20.364 6.5c-2.183 2.078-4.533 3.511-6.941 4.489.505 1.129.972 2.265 1.396 3.4 1.567-.305 3.623-.187 5.322.25A10.137 10.137 0 0 0 20.364 6.5z"/>',
            'label' => 'Dribbble',
            'prefix' => 'https://dribbble.com/',
        ],
        'figma' => [
            'svg' => '<path d="M12 24c-3.314 0-6-2.686-6-6V6c0-3.314 2.686-6 6-6s6 2.686 6 6v12c0 3.314-2.686 6-6 6zM9 12a3 3 0 0 0 3 3h3v-6h-3a3 3 0 0 0-3 3zm0-6a3 3 0 0 0 3 3h3V3h-3a3 3 0 0 0-3 3zm6 12a3 3 0 0 0-3-3h-3a3 3 0 0 0 0 6h3a3 3 0 1 0 3-3z"/>',
            'label' => 'Figma',
            'prefix' => 'https://www.figma.com/@',
        ],
    ];

    $buildUrl = function($key, $val) use ($socials) {
        if (str_starts_with($val, 'http')) return $val;
        return ($socials[$key]['prefix'] ?? '') . ltrim($val, '@');
    };

    $name = $get('name', 'Developer');
    $title = $get('title', 'Portfolio'); 
    $bio = $get('bio');
    $avatar = $get('avatar_url');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $name }} — {{ $title }}</title>
    <meta name="description" content="{{ Str::limit($bio, 160) }}">
    
    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $name }}">
    <meta property="og:description" content="{{ Str::limit($bio, 160) }}">
    <meta property="og:image" content="{{ $avatar }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">
    @if($handle = $get('socials.twitter'))
        <meta name="twitter:creator" content="{{ '@' . ltrim($handle, '@') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 antialiased transition-colors duration-300">

    <div class="fixed inset-0 -z-10 h-full w-full bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] dark:bg-[radial-gradient(#1f2937_1px,transparent_1px)] dark:[mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-50 pointer-events-none"></div>

    <header 
        x-data="{ scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white/70 dark:bg-gray-950/70 shadow-sm backdrop-blur-md' : 'bg-transparent'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-transparent"
        :class="{ 'border-gray-200 dark:border-gray-800': scrolled }"
    >
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="#top" class="flex items-center gap-3 group">
                <div class="relative h-9 w-9 overflow-hidden rounded-full ring-2 ring-white dark:ring-gray-800 shadow-sm transition-transform group-hover:scale-105">
                    <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover">
                </div>
                <span class="font-bold text-lg tracking-tight group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $name }}</span>
            </a>

            <div class="flex items-center gap-4">
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600 dark:text-gray-400">
                    @if(count($get('projects', []))) <a href="#projects" class="hover:text-gray-900 dark:hover:text-white transition-colors">Projects</a> @endif
                    @if(count($get('experiences', []))) <a href="#experience" class="hover:text-gray-900 dark:hover:text-white transition-colors">Experience</a> @endif
                </nav>

                <div class="h-4 w-px bg-gray-200 dark:bg-gray-800 hidden md:block"></div>

                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        class="p-2 w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                        onclick="localStorage.theme === 'dark' ? localStorage.theme = 'light' : localStorage.theme = 'dark'; if (localStorage.theme === 'dark') { document.documentElement.classList.add('dark') } else { document.documentElement.classList.remove('dark') }"
                    >
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    @auth
                        <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                            <button @click="open = !open" class="h-8 w-8 rounded-full overflow-hidden ring-2 ring-gray-100 dark:ring-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <img src="{{ Auth::user()->avatar() }}" alt="User" class="h-full w-full object-cover">
                            </button>
                            <div x-show="open" 
                                 x-transition.origin.top.right
                                 class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-gray-900 shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-gray-800 py-1 focus:outline-none" 
                                 style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 dark:border-gray-800">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 pt-32 pb-20 space-y-24">
        
        <section id="top" class="animate-fade-in-up">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-8">
                <div class="space-y-6 max-w-lg">
                    <div class="space-y-2">
                        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            {{ $name }}
                        </h1>
                        <p class="text-xl font-medium text-primary-600 dark:text-primary-400">
                            {{ $title }}
                        </p>
                    </div>
                    
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $bio }}
                    </p>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                        @if($loc = $get('location'))
                            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800/50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                {{ $loc }}
                            </div>
                        @endif
                        @if($email = $get('email'))
                            <a href="mailto:{{ $email }}" class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800/50 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                {{ $email }}
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        @foreach($socials as $key => $conf)
                            @if($handle = $get("socials.$key"))
                                <a href="{{ $buildUrl($key, $handle) }}" target="_blank" rel="noopener noreferrer" 
                                   class="h-10 w-10 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-800 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-600 transition-all bg-white dark:bg-gray-900 shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">{!! $conf['svg'] !!}</svg>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-primary-500/10 dark:bg-primary-400/10 blur-2xl rounded-full"></div>
                    <img src="{{ $avatar }}" alt="{{ $name }}" class="relative h-32 w-32 md:h-40 md:w-40 rounded-2xl object-cover shadow-xl rotate-3 ring-1 ring-white/10 dark:ring-white/5">
                </div>
            </div>
        </section>

        @if($about = $get('about_me'))
            <section class="scroll-mt-24 space-y-6">
                <h2 class="text-2xl font-bold tracking-tight">About</h2>
                <div class="prose prose-gray dark:prose-invert max-w-none prose-p:leading-relaxed">
                    {!! nl2br(e($about)) !!}
                </div>
            </section>
        @endif

        @if($skills = $get('skills'))
            <section class="space-y-6">
                <h2 class="text-2xl font-bold tracking-tight">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-transparent hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-default">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </section>
        @endif

        @if($experiences = $get('experiences'))
            <section id="experience" class="scroll-mt-24 space-y-8">
                <h2 class="text-2xl font-bold tracking-tight">Work Experience</h2>
                <div class="relative border-l-2 border-gray-200 dark:border-gray-800 ml-3 space-y-12">
                    @foreach($experiences as $exp)
                        <div class="relative pl-8 group">
                            <div class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full border-2 border-white dark:border-gray-950 bg-gray-200 dark:bg-gray-700 group-hover:bg-primary-500 group-hover:scale-110 transition-all"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exp['title'] }}</h3>
                                <span class="text-sm font-mono text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $formatDate($exp['start_date']) }} — {{ $formatDate($exp['end_date'], true) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                <span>{{ $exp['company'] }}</span>
                                @if(!empty($exp['location']))
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-500">{{ $exp['location'] }}</span>
                                @endif
                            </div>

                            @if(!empty($exp['description']))
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($projects = $get('projects'))
            <section id="projects" class="scroll-mt-24 space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold tracking-tight">Selected Projects</h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-xs font-bold">{{ count($projects) }}</span>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($projects as $project)
                        <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 transition-all hover:shadow-lg hover:border-gray-300 dark:hover:border-gray-700">
                            @if(!empty($project['image_path']))
                                <div class="aspect-[16/9] overflow-hidden bg-gray-100 dark:bg-gray-800">
                                    <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @endif
                            
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    @if($project['url'])
                                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">
                                            <span class="absolute inset-0"></span>
                                            {{ $project['title'] }}
                                        </a>
                                    @else
                                        {{ $project['title'] }}
                                    @endif
                                </h3>
                                
                                @if(!empty($project['description']))
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ $project['description'] }}</p>
                                @endif

                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    @if($project['url'])
                                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400 flex items-center gap-1">
                                            Visit Project <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M7 17L17 7M17 7H7M17 7V17"/></svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($education = $get('education'))
            <section class="space-y-8 border-t border-gray-100 dark:border-gray-800 pt-10">
                <h2 class="text-xl font-bold tracking-tight">Education</h2>
                <div class="space-y-6">
                    @foreach($education as $edu)
                        <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $edu['school'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $edu['degree'] }}@if($edu['degree'] && $edu['field_of_study']), @endif{{ $edu['field_of_study'] }}
                                </p>
                            </div>
                            <div class="text-sm font-mono text-gray-500">
                                {{ $formatDate($edu['start_date']) }} — {{ $formatDate($edu['end_date']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ $name }}. All rights reserved.</p>
                
                <div class="flex items-center gap-4">
                    @if($reqCount = $get('api_request_count'))
                        <span class="font-mono text-xs opacity-70 flex items-center gap-1" title="API Hits">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            {{ number_format($reqCount) }}
                        </span>
                    @endif
                    <a href="https://mtex.dev" target="_blank" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">mtex.dev</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>