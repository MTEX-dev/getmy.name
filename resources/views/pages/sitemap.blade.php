@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Sitemap') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                    {{ __('Public Pages') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li><a href="{{ route('lander') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Log In') }}</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Register') }}</a></li>
                    @endif
                    <li><a href="{{ route('sitemap') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Sitemap') }}</a></li>
                </ul>

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('Legal Pages') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    @if (isset($legalSections))
                        @foreach ($legalSections as $legalSection)
                            <li><a href="{{ route('legal', ['section' => $legalSection]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('legal.' . $legalSection . '.title') }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('legal', 'imprint') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Imprint') }}</a></li>
                        <li><a href="{{ route('legal', 'privacy') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Privacy Policy') }}</a></li>
                        <li><a href="{{ route('legal', 'terms') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Terms of Service') }}</a></li>
                    @endif
                </ul>

                @auth
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                        {{ __('Authenticated Pages') }}
                    </h3>
                    <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                        <li><a href="{{ route('dashboard') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Account Settings') }}</a></li>
                        @if (auth()->user())
                            <li><a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Edit Core Profile Info') }}</a></li>
                            <li><a href="{{ route('profile.skills') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Manage Skills') }}</a></li>
                            <li><a href="{{ route('profile.projects') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Manage Projects') }}</a></li>
                            <li><a href="{{ route('profile.experiences') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Manage Experiences') }}</a></li>
                            <li><a href="{{ route('profile.education') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Manage Education') }}</a></li>
                            <li><a href="{{ route('profile.socials') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Manage Socials') }}</a></li>
                            <li><a href="{{ route('profile.api-requests.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('API Request Logs') }}</a></li>
                            <li><a href="{{ route('profile.preview') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Profile Preview') }}</a></li>
                        @endif
                    </ul>
                @endauth

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('External Links') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li><a href="https://fternis.de" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">Fabian Ternis Portfolio</a></li>
                    <li><a href="https://mtex.dev" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">mtex.dev</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection