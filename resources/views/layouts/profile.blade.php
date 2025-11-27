<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body class="font-sans antialiased flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('components.navbar')

    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-gray-200 to-transparent dark:from-gray-700 dark:to-transparent -z-10"></div>

    <div class="flex-1 @if (!isset($startAtFooter) || $startAtFooter !== true) pt-16 @endif">
        <div class="flex">
            <aside class="w-64 bg-white dark:bg-gray-800 shadow h-screen sticky top-16">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Profile</h2>
                    <nav class="mt-4">
                        @php
                            $baseClass = 'block w-full px-4 py-2 text-start text-sm leading-5 transition duration-150 ease-in-out ';
                            $activeClass = $baseClass . 'bg-getmyname-50 dark:bg-gray-700 border-l-4 border-getmyname-400 dark:border-getmyname-600 text-getmyname-700 dark:text-getmyname-300 focus:outline-none focus:bg-getmyname-100 dark:focus:bg-gray-700 focus:border-getmyname-700 dark:focus:border-getmyname-300';
                            $inactiveClass = $baseClass . 'border-l-4 border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600';
                        @endphp
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.profile') }}
                        </a>
                        <a href="{{ route('profile.password') }}" class="{{ request()->routeIs('profile.password') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.password') }}
                        </a>
                        <a href="{{ route('profile.avatar') }}" class="{{ request()->routeIs('profile.avatar') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.avatar') }}
                        </a>
                        <a href="{{ route('profile.design') }}" class="{{ request()->routeIs('profile.design') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.design') }}
                        </a>
                        <a href="{{ route('profile.about-me') }}" class="{{ request()->routeIs('profile.about-me') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.about_me_title') }}
                        </a>
                        <a href="{{ route('profile.skills') }}" class="{{ request()->routeIs('profile.skills') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.skills') }}
                        </a>
                        <a href="{{ route('profile.projects') }}" class="{{ request()->routeIs('profile.projects') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.projects.title') }}
                        </a>
                        <a href="{{ route('profile.experiences') }}" class="{{ request()->routeIs('profile.experiences') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.experiences.title') }}
                        </a>
                        <a href="{{ route('profile.education') }}" class="{{ request()->routeIs('profile.education') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.education') }}
                        </a>
                        <a href="{{ route('profile.socials') }}" class="{{ request()->routeIs('profile.socials') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.socials.title') }}
                        </a>
                        <a href="{{ route('profile.preview') }}" class="{{ request()->routeIs('profile.preview') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.preview.title') }}
                        </a>
                        <a href="{{ route('profile.api-requests.index') }}" class="{{ request()->routeIs('profile.api-requests.index') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.api_requests.title') }}
                        </a>
                        <a href="{{ route('profile.api-tokens.index') }}" class="{{ request()->routeIs('profile.api-tokens.index') ? $activeClass : $inactiveClass }}">
                            {{ __('API Tokens') }}
                        </a>
                        <a href="{{ route('profile.activity') }}" class="{{ request()->routeIs('profile.activity') ? $activeClass : $inactiveClass }}">
                            {{ __('profile.activity.title') }}
                        </a>
                    </nav>
                </div>
            </aside>
            <main class="w-full">
                @hasSection('header')
                    <header class="bg-white dark:bg-gray-800 shadow">
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