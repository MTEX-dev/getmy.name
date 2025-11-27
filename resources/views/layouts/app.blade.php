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
    @include('components.toast-messages')

    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-gray-200 to-transparent dark:from-gray-700 dark:to-transparent -z-10"></div>

    <div class="flex-1 @if (!isset($startAtFooter) || $startAtFooter !== true) pt-16 @endif">
        @hasSection('header')
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    @if (!isset($hideFooter) || $hideFooter !== true)
        @include('components.footer')
    @endif


    @stack('scripts')
</body>
</html>
