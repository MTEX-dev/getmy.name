@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('sitemap.sitemap') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                    {{ __('sitemap.public_pages') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li><a href="{{ route('lander') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('auth.login') }}</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('auth.register') }}</a></li>
                    @endif
                    <li><a href="{{ route('sitemap') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.sitemap') }}</a></li>
                    <li><a href="{{ route('api-docs') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.api_docs') }}</a></li>
                </ul>

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('sitemap.legal_pages') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    @if (isset($legalSections))
                        @foreach ($legalSections as $legalSection)
                            <li><a href="{{ route('legal', ['section' => $legalSection]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('legal.' . $legalSection . '.title') }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('legal', 'imprint') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('legal.imprint.title') }}</a></li>
                        <li><a href="{{ route('legal', 'privacy') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('legal.privacy.title') }}</a></li>
                        <li><a href="{{ route('legal', 'terms') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('legal.terms.title') }}</a></li>
                    @endif
                </ul>

                @auth
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                        {{ __('sitemap.authenticated_pages') }}
                    </h3>
                    <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                        <li><a href="{{ route('dashboard') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('strings.dashboard') }}</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.account_settings') }}</a></li>
                        @if (auth()->user())
                            <li><a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.edit_core_profile_info') }}</a></li>
                            <li><a href="{{ route('profile.skills') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.manage_skills') }}</a></li>
                            <li><a href="{{ route('profile.projects') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.manage_projects') }}</a></li>
                            <li><a href="{{ route('profile.experiences') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.manage_experiences') }}</a></li>
                            <li><a href="{{ route('profile.education') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.manage_education') }}</a></li>
                            <li><a href="{{ route('profile.socials') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.manage_socials') }}</a></li>
                            <li><a href="{{ route('profile.api-requests.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.api_request_logs') }}</a></li>
                            <li><a href="{{ route('profile.preview') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('sitemap.profile_preview') }}</a></li>
                        @endif
                    </ul>
                @endauth

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('sitemap.external_links') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li><a href="https://fternis.de" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">Fabian Ternis Portfolio</a></li>
                    <li><a href="https://mtex.dev" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">mtex.dev</a></li>
                </ul>

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('sitemap.user_portfolios') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    @forelse($users as $user)
                        <li><a href="{{ route('profile.get', ['username' => $user->username]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $user->username }}</a></li>
                    @empty
                        <li>{{ __('sitemap.no_public_portfolios') }}</li>
                    @endforelse
                </ul>

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('sitemap.user_data_endpoints') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    @forelse($users as $user)
                        <li><a href="{{ route('profile.get.data', ['username' => $user->username]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }}</a></li>
                    @empty
                        <li>{{ __('sitemap.no_public_user_data_endpoints') }}</li>
                    @endforelse
                </ul>

                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-10 mb-6">
                    {{ __('sitemap.api_endpoints') }}
                </h3>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    @forelse($users as $user)
                        <li><a href="{{ url('/api/v1/profile/' . $user->username) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - Profile</a></li>
                        <li><a href="{{ url('/api/v1/profile/' . $user->username . '/skills') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - Skills</a></li>
                        <li><a href="{{ url('/api/v1/profile/' . $user->username . '/projects') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - Projects</a></li>
                        <li><a href="{{ url('/api/v1/profile/' . $user->username . '/experiences') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - Experiences</a></li>
                        <li><a href="{{ url('/api/v1/profile/' . $user->username . '/education') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - Education</a></li>
                        <li><a href="{{ url('/api/v1/profile/' . $user->username . '/socials') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - Socials</a></li>
                        <li><a href="{{ url('/api/v1/profile/' . $user->username . '/about-me') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline" target="_blank">{{ $user->username }} - About Me</a></li>
                    @empty
                        <li>{{ __('sitemap.no_public_api_endpoints') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection