@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('profile.profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('profile.partials.nav')
            
            <!-- Profile Preview -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Profile Preview</h3>
                    
                    <!-- Header Section -->
                    <div class="flex flex-col lg:flex-row gap-8 mb-8">
                        <!-- Avatar Section -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                @if($data['avatar_url'])
                                    <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Profile Info -->
                        <div class="flex-grow">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $data['name'] }}</h1>
                            <p class="text-lg text-blue-600 dark:text-blue-400 mb-2">{{ $data['title'] }}</p>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">{{ '@'.$data['username'] }}</p>
                            @if($data['location'])
                                <p class="text-gray-600 dark:text-gray-300 mb-4">📍 {{ $data['location'] }}</p>
                            @endif
                            @if($data['bio'])
                                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $data['bio'] }}</p>
                            @endif
                            
                            <!-- Social Links -->
                            <div class="flex gap-4 mb-4">
                                @if($data['socials']['github'])
                                    <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <span class="sr-only">GitHub</span>
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($data['socials']['linkedin'])
                                    <a href="https://linkedin.com/in/{{ $data['socials']['linkedin'] }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <span class="sr-only">LinkedIn</span>
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($data['socials']['twitter'])
                                    <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <span class="sr-only">Twitter</span>
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($data['socials']['personal_website'])
                                    <a href="{{ $data['socials']['personal_website'] }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <span class="sr-only">Website</span>
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Skills Section -->
                    @if(!empty($data['skills']))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Skills</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($data['skills'] as $skill)
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Experience Section -->
                    @if(!empty($data['experiences']))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Experience</h3>
                            <div class="space-y-6">
                                @foreach($data['experiences'] as $experience)
                                    <div class="border-l-2 border-blue-200 dark:border-blue-700 pl-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $experience['title'] }}</h4>
                                        <p class="text-blue-600 dark:text-blue-400 font-medium">{{ $experience['company'] }}</p>
                                        @if($experience['location'])
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $experience['location'] }}</p>
                                        @endif
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                                            {{ \Carbon\Carbon::parse($experience['start_date'])->format('M Y') }} - 
                                            {{ \Carbon\Carbon::parse($experience['end_date'])->format('M Y') }}
                                        </p>
                                        @if($experience['description'])
                                            <p class="text-gray-700 dark:text-gray-300">{{ $experience['description'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Projects Section -->
                    @if(!empty($data['projects']))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Projects</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($data['projects'] as $project)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                        @if($project['image_path'])
                                            <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                        @endif
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $project['title'] }}</h4>
                                        @if($project['description'])
                                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $project['description'] }}</p>
                                        @endif
                                        @if($project['url'])
                                            <a href="{{ $project['url'] }}" target="_blank" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                                View Project
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- API Usage -->
                    <div class="text-sm text-gray-500 dark:text-gray-400 text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        API Requests: {{ $data['api_request_count'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection