<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MTEX.dev') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body class="font-sans antialiased flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: true }">
    @include('components.navbar')
    @include('components.toast-messages')

    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-gray-200 to-transparent dark:from-gray-700 dark:to-transparent -z-10"></div>

    <div class="flex-1 @if (!isset($startAtFooter) || $startAtFooter !== true) pt-16 @endif">
        <div class="flex relative">
            <aside x-show="sidebarOpen" x-transition:enter="transition-transform ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="w-64 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-r border-gray-200 dark:border-gray-700 shadow-sm h-[calc(100vh-4rem)] sticky top-16 overflow-y-auto">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('profile.profile') }}</h2>
                        <button @click="sidebarOpen = false" class="p-1.5 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-150" title="Close sidebar">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" /></svg>
                        </button>
                    </div>
                    <nav class="flex flex-col gap-1">
                        @php
                            $baseClass = 'flex items-center px-3 py-2 text-sm transition-all duration-150 rounded-xl ';
                            $activeClass = $baseClass . 'bg-getmyname-50 dark:bg-getmyname-900/20 text-getmyname-700 dark:text-getmyname-400 font-semibold shadow-sm';
                            $inactiveClass = $baseClass . 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50';
                        @endphp
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? $activeClass : $inactiveClass }}">{{ __('profile.profile') }}</a>
                        <a href="{{ route('profile.password') }}" class="{{ request()->routeIs('profile.password') ? $activeClass : $inactiveClass }}">{{ __('profile.password') }}</a>
                        <a href="{{ route('profile.avatar') }}" class="{{ request()->routeIs('profile.avatar') ? $activeClass : $inactiveClass }}">{{ __('profile.avatar') }}</a>
                        <a href="{{ route('profile.design') }}" class="{{ request()->routeIs('profile.design') ? $activeClass : $inactiveClass }}">{{ __('profile.design') }}</a>
                        <a href="{{ route('profile.about-me') }}" class="{{ request()->routeIs('profile.about-me') ? $activeClass : $inactiveClass }}">{{ __('profile.about_me_title') }}</a>
                        <a href="{{ route('profile.skills') }}" class="{{ request()->routeIs('profile.skills') ? $activeClass : $inactiveClass }}">{{ __('profile.skills') }}</a>
                        <a href="{{ route('profile.projects') }}" class="{{ request()->routeIs('profile.project*') ? $activeClass : $inactiveClass }}">{{ __('profile.projects.title') }}</a>
                        <a href="{{ route('profile.experiences') }}" class="{{ request()->routeIs('profile.experiences') ? $activeClass : $inactiveClass }}">{{ __('profile.experiences.title') }}</a>
                        <a href="{{ route('profile.education') }}" class="{{ request()->routeIs('profile.education') ? $activeClass : $inactiveClass }}">{{ __('profile.education') }}</a>
                        <a href="{{ route('profile.socials') }}" class="{{ request()->routeIs('profile.socials') ? $activeClass : $inactiveClass }}">{{ __('profile.socials.title') }}</a>
                        <a href="{{ route('profile.preview') }}" class="{{ request()->routeIs('profile.preview') ? $activeClass : $inactiveClass }}">{{ __('profile.preview.title') }}</a>
                        <a href="{{ route('profile.api-requests.index') }}" class="{{ request()->routeIs('profile.api-requests.index') ? $activeClass : $inactiveClass }}">{{ __('profile.api_requests.title') }}</a>
                        <a href="{{ route('profile.api-tokens.index') }}" class="{{ request()->routeIs('profile.api-tokens.index') ? $activeClass : $inactiveClass }}">{{ __('API Tokens') }}</a>
                        <a href="{{ route('profile.activity') }}" class="{{ request()->routeIs('profile.activity') ? $activeClass : $inactiveClass }}">{{ __('profile.activity.title') }}</a>
                    </nav>
                </div>
            </aside>

            <button x-show="!sidebarOpen" @click="sidebarOpen = true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="fixed left-4 top-20 z-40 p-2.5 rounded-xl bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border border-gray-200 dark:border-gray-700 shadow-lg text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 transition-all duration-150" title="Open sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>

            <main class="flex-1 transition-all duration-300" :class="{ 'ml-0': !sidebarOpen }">
                @hasSection('header')
                    <header class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @yield('header')
                        </div>
                    </header>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    @if (!isset($hideFooter) || $hideFooter !== true)
        @include('components.footer')
    @endif

    @stack('scripts')
</body>
</html>