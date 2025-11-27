<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('errors.' . class_basename($exception) . '.title', ['exception' => class_basename($exception)]) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div
        class="relative min-h-screen flex flex-col items-center justify-center p-4 dark:bg-gray-900 dark:text-gray-100"
    >
        <div class="absolute top-4 right-4 z-20">
            @include('components.theme-toggle')
        </div>

        <div
            class="relative z-10 text-center flex flex-col items-center justify-center"
        >
            <h2 class="text-4xl font-semibold text-getmyname-500 mb-2">
                {{ __('errors.' . $exception->getStatusCode() . '.title',['status' => $exception->getStatusCode()],) }}
            </h2>
            <p class="text-xl text-gray-700 dark:text-gray-300 mb-8">
                {{ __('errors.' . $exception->getStatusCode() . '.description',['status' => $exception->getStatusCode()],) }}
            </p>

            <a
                href="{{ url('/') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-getmyname-600 hover:bg-getmyname-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-getmyname-500"
            >
                {{ __('errors.go_home') }}
            </a>
        </div>

        <h1
            class="absolute inset-0 flex items-center justify-center text-[22rem] font-extrabold text-getmyname-600 opacity-10 dark:text-getmyname-400"
            style="line-height: 1"
        >
            {{ $exception->getStatusCode() }}
        </h1>
        <p class="mt-4">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights
            reserved.
        </p>
    </div>
</body>
</html>