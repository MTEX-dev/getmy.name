@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('sitemap.sitemap') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- COLUMN 1: NAVIGATION & ACCOUNT -->
                <div class="space-y-8">
                    <!-- Public Pages -->
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-4 text-getmyname-600 dark:text-getmyname-400 font-bold uppercase tracking-tight">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            {{ __('sitemap.public_pages') }}
                        </div>
                        <ul class="space-y-3 text-sm">
                            <li><a href="{{ route('lander') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('auth.login') }}</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('auth.register') }}</a></li>
                            @endif
                            <li><a href="{{ route('api-docs') }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('sitemap.api_docs') }}</a></li>
                            <li><a href="{{ route('stats.platform', ['metric' =>'api-requests']) }}" class="text-gray-600 dark:text-gray-400 hover:text-getmyname-600 transition-colors">{{ __('stats.platform') }}</a></li>
                        </ul>
                    </section>

                    <!-- Authenticated (conditional) -->
                    @auth
                    <section class="bg-getmyname-50 dark:bg-getmyname-950/20 p-6 rounded-xl border border-getmyname-100 dark:border-getmyname-900/30">
                        <div class="flex items-center mb-4 text-getmyname-700 dark:text-getmyname-300 font-bold uppercase tracking-tight">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('sitemap.authenticated_pages') }}
                        </div>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('dashboard') }}" class="font-bold text-getmyname-700 dark:text-getmyname-400">{{ __('strings.dashboard') }}</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">Core Profile</a></li>
                            <li><a href="{{ route('profile.skills') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">Skills</a></li>
                            <li><a href="{{ route('profile.projects') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">Projects</a></li>
                            <li><a href="{{ route('profile.experiences') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">Experiences</a></li>
                            <li><a href="{{ route('profile.education') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">Education</a></li>
                            <li><a href="{{ route('profile.socials') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">Socials</a></li>
                            <li><a href="{{ route('profile.api-requests.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-getmyname-600">API Logs</a></li>
                        </ul>
                    </section>
                    @endauth

                    <!-- Legal -->
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-sm font-bold text-gray-400 uppercase mb-4 tracking-widest">{{ __('sitemap.legal_pages') }}</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('legal', 'imprint') }}" class="text-gray-500 dark:text-gray-400 hover:text-getmyname-600">{{ __('legal.imprint.title') }}</a></li>
                            <li><a href="{{ route('legal', 'privacy') }}" class="text-gray-500 dark:text-gray-400 hover:text-getmyname-600">{{ __('legal.privacy.title') }}</a></li>
                            <li><a href="{{ route('legal', 'terms') }}" class="text-gray-500 dark:text-gray-400 hover:text-getmyname-600">{{ __('legal.terms.title') }}</a></li>
                        </ul>
                    </section>
                </div>

                <!-- COLUMN 2: MTEX ECOSYSTEM (EXTERNAL) -->
                <div class="space-y-8">
                    <section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6 text-gray-900 dark:text-white font-bold uppercase tracking-tight">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                            MTEX Ecosystem
                        </div>

                        <!-- Core Domains -->
                        <div class="mb-6">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Core & Status</p>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="https://mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://index.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">index.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://status.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">status.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://legal.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">legal.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                            </div>
                        </div>

                        <!-- Dev Tools -->
                        <div class="mb-6">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Developer Tools</p>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="https://tw.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">tw.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://nx.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">nx.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://diff.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">diff.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://github.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">github.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://gh.mtex.dev" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">gh.mtex.dev</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                            </div>
                        </div>

                        <!-- Projects -->
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Active Projects</p>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="https://getmy.name" target="_blank" class="flex justify-between items-center p-2 rounded bg-getmyname-50/50 dark:bg-getmyname-900/20 border border-getmyname-100 dark:border-getmyname-800 group">
                                    <code class="text-xs font-bold text-getmyname-700 dark:text-getmyname-400">getmy.name</code>
                                    <span class="text-getmyname-300">→</span>
                                </a>
                                <a href="https://api.getmy.name" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">api.getmy.name</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://getmy.blog" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">getmy.blog</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                                <a href="https://gimy.site" target="_blank" class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-getmyname-50 transition-colors group">
                                    <code class="text-xs text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600">gimy.site</code>
                                    <span class="text-gray-300">→</span>
                                </a>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- COLUMN 3: API ENDPOINT MAP -->
                <div class="space-y-8">
                    <section class="bg-gray-900 dark:bg-black p-6 rounded-xl shadow-lg border border-getmyname-900/30">
                        <div class="flex items-center mb-6 text-getmyname-400 font-bold uppercase tracking-tight">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            v1 API Endpoints
                        </div>

                        <!-- Platform Stats -->
                        <div class="mb-8">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Global Stats</p>
                            <div class="space-y-2 font-mono text-[11px]">
                                <a href="{{ url('/api/v1/stats/requests/platform') }}" target="_blank" class="block p-2 rounded bg-gray-800/50 text-getmyname-400 hover:bg-gray-800 transition-colors">
                                    GET /stats/requests/platform
                                </a>
                            </div>
                        </div>

                        <!-- User Specific Endpoints -->
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">User Profile Endpoints</p>
                        <div class="max-h-[600px] overflow-y-auto pr-2 custom-scrollbar space-y-6">
                            @forelse($users as $user)
                                <div class="relative pl-4 border-l border-gray-800">
                                    <div class="absolute -left-1 top-0 w-2 h-2 rounded-full bg-getmyname-600"></div>
                                    <p class="text-xs font-bold text-white mb-2 tracking-wide">{{ $user->username }}</p>
                                    
                                    <div class="flex flex-col space-y-1 font-mono text-[10px]">
                                        <a href="{{ url('/api/v1/profile/'.$user->username) }}" target="_blank" class="text-getmyname-500 hover:text-white transition-colors">GET /profile</a>
                                        <a href="{{ url('/api/v1/profile/'.$user->username.'/skills') }}" target="_blank" class="text-gray-400 hover:text-getmyname-400 transition-colors">GET /profile/skills</a>
                                        <a href="{{ url('/api/v1/profile/'.$user->username.'/projects') }}" target="_blank" class="text-gray-400 hover:text-getmyname-400 transition-colors">GET /profile/projects</a>
                                        <a href="{{ url('/api/v1/profile/'.$user->username.'/experiences') }}" target="_blank" class="text-gray-400 hover:text-getmyname-400 transition-colors">GET /profile/experiences</a>
                                        <a href="{{ url('/api/v1/profile/'.$user->username.'/education') }}" target="_blank" class="text-gray-400 hover:text-getmyname-400 transition-colors">GET /profile/education</a>
                                        <a href="{{ url('/api/v1/profile/'.$user->username.'/socials') }}" target="_blank" class="text-gray-400 hover:text-getmyname-400 transition-colors">GET /profile/socials</a>
                                        <a href="{{ url('/api/v1/profile/'.$user->username.'/about-me') }}" target="_blank" class="text-gray-400 hover:text-getmyname-400 transition-colors">GET /profile/about-me</a>
                                        <a href="{{ url('/api/v1/stats/requests/user/'.$user->username) }}" target="_blank" class="text-orange-400/70 hover:text-orange-300 transition-colors">GET /stats/requests/user</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-600 italic">No public user data available.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #000; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #14532d; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #16a34a; }
    </style>
@endsection