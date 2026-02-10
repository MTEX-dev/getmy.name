@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('sitemap.sitemap') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Column 1: Core Navigation -->
                <div class="space-y-8">
                    <!-- Public Pages -->
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-4 text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">{{ __('sitemap.public_pages') }}</h3>
                        </div>
                        <ul class="space-y-3">
                            <li><a href="{{ route('lander') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors flex items-center"><span>{{ __('Home') }}</span></a></li>
                            <li><a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('auth.login') }}</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('auth.register') }}</a></li>
                            @endif
                            <li><a href="{{ route('api-docs') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('sitemap.api_docs') }}</a></li>
                            <li><a href="{{ route('stats.platform', ['metric' =>'api-requests']) }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('stats.platform') }}</a></li>
                        </ul>
                    </section>

                    <!-- Legal Pages -->
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-4 text-gray-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">{{ __('sitemap.legal_pages') }}</h3>
                        </div>
                        <ul class="space-y-3">
                            @if (isset($legalSections))
                                @foreach ($legalSections as $legalSection)
                                    <li><a href="{{ route('legal', ['section' => $legalSection]) }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('legal.' . $legalSection . '.title') }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ route('legal', 'imprint') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('legal.imprint.title') }}</a></li>
                                <li><a href="{{ route('legal', 'privacy') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('legal.privacy.title') }}</a></li>
                                <li><a href="{{ route('legal', 'terms') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('legal.terms.title') }}</a></li>
                            @endif
                        </ul>
                    </section>
                </div>

                <!-- Column 2: User Access & Dynamic Content -->
                <div class="space-y-8">
                    @auth
                        <!-- Authenticated User Settings -->
                        <section class="bg-indigo-50 dark:bg-gray-900/50 p-6 rounded-xl border border-indigo-100 dark:border-indigo-900/30 shadow-sm">
                            <div class="flex items-center mb-4 text-indigo-700 dark:text-indigo-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <h3 class="text-lg font-bold uppercase tracking-tight">{{ __('sitemap.authenticated_pages') }}</h3>
                            </div>
                            <ul class="space-y-2 text-sm">
                                <li><a href="{{ route('dashboard') }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('strings.dashboard') }}</a></li>
                                <li><a href="{{ route('profile.edit') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.edit_core_profile_info') }}</a></li>
                                <li><a href="{{ route('profile.skills') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.manage_skills') }}</a></li>
                                <li><a href="{{ route('profile.projects') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.manage_projects') }}</a></li>
                                <li><a href="{{ route('profile.experiences') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.manage_experiences') }}</a></li>
                                <li><a href="{{ route('profile.education') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.manage_education') }}</a></li>
                                <li><a href="{{ route('profile.socials') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.manage_socials') }}</a></li>
                                <li><a href="{{ route('profile.api-requests.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.api_request_logs') }}</a></li>
                                <li><a href="{{ route('profile.preview') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-colors">{{ __('sitemap.profile_preview') }}</a></li>
                            </ul>
                        </section>
                    @endauth

                    <!-- Public Portfolios -->
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-4 text-emerald-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">{{ __('sitemap.user_portfolios') }}</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse($users as $user)
                                <a href="{{ route('profile.get', ['username' => $user->username]) }}" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm text-gray-700 dark:text-gray-300 hover:bg-getmyname-500 hover:text-white transition-all">
                                    {{ $user->username }}
                                </a>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('sitemap.no_public_portfolios') }}</p>
                            @endforelse
                        </div>
                    </section>
                </div>

                <!-- Column 3: Ecosystem & API -->
                <div class="space-y-8">
                    <!-- MTEX Ecosystem (The "External Links" update) -->
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-4 text-orange-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.827a4 4 0 005.656 0l4-4a4 4 0 10-5.656-5.656l-1.1 1.1"/></svg>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">{{ __('sitemap.external_links') }}</h3>
                        </div>
                        <ul class="space-y-3 text-sm">
                            <li><a href="https://mtex.dev" target="_blank" class="font-medium text-gray-800 dark:text-gray-200 hover:text-orange-500">mtex.dev <span class="text-xs font-normal opacity-60">— Portfolio</span></a></li>
                            <li><a href="https://github.mtex.dev" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-orange-500">github.mtex.dev</a></li>
                            <li><a href="https://status.mtex.dev" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-orange-500">System Status</a></li>
                            <hr class="border-gray-100 dark:border-gray-700">
                            <li><a href="https://tw.mtex.dev" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-orange-500 italic">tw.mtex.dev — Tailwind Lib</a></li>
                            <li><a href="https://diff.mtex.dev" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-orange-500 italic">diff.mtex.dev — JSON Diff</a></li>
                            <li><a href="https://nx.mtex.dev" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-orange-500 italic">nx.mtex.dev — API Gateway</a></li>
                            <hr class="border-gray-100 dark:border-gray-700">
                            <li><a href="https://api-sandbox.de" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-indigo-500 font-semibold tracking-wide">api-sandbox.de</a></li>
                        </ul>
                    </section>

                    <!-- API Access -->
                    <section class="bg-gray-900 dark:bg-black p-6 rounded-xl shadow-lg border border-gray-800">
                        <div class="flex items-center mb-4 text-pink-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            <h3 class="text-lg font-bold text-white uppercase tracking-tight">{{ __('sitemap.api_endpoints') }}</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                            @forelse($users as $user)
                                <div class="border-b border-gray-800 pb-2">
                                    <p class="text-xs font-bold text-gray-500 mb-1 tracking-widest uppercase">{{ $user->username }}</p>
                                    <div class="grid grid-cols-1 gap-1">
                                        <a href="{{ url('/api/v1/profile/' . $user->username) }}" class="text-xs text-pink-400 hover:text-white transition-colors">/v1/profile/{{ $user->username }}</a>
                                        <a href="{{ url('/api/v1/profile/' . $user->username . '/skills') }}" class="text-xs text-pink-400/80 hover:text-white transition-colors">.../skills</a>
                                        <a href="{{ url('/api/v1/profile/' . $user->username . '/projects') }}" class="text-xs text-pink-400/80 hover:text-white transition-colors">.../projects</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-600">{{ __('sitemap.no_public_api_endpoints') }}</p>
                            @endforelse
                        </div>
                    </section>
                </div>

            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4B5563; }
    </style>
@endsection