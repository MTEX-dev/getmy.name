<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        
        {{-- Hero Section --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-32"></div>
            <div class="px-8 pb-8">
                <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 mb-6">
                    <img src="{{ $data['avatar_url'] }}" 
                         alt="{{ $data['name'] }}" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-lg mb-4 md:mb-0">
                    <div class="md:ml-6 flex-1">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $data['name'] }}</h1>
                        <p class="text-xl text-indigo-600 font-medium">{{ $data['title'] }}</p>
                        @if($data['location'])
                            <p class="text-gray-600 mt-1">📍 {{ $data['location'] }}</p>
                        @endif
                    </div>
                    
                    {{-- Social Links --}}
                    @if($data['socials'])
                        <div class="flex gap-3 mt-4 md:mt-0">
                            @if(!empty($data['socials']['github']))
                                <a href="{{ $data['socials']['github'] }}" target="_blank" 
                                   class="w-10 h-10 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                </a>
                            @endif
                            @if(!empty($data['socials']['linkedin']))
                                <a href="{{ $data['socials']['linkedin'] }}" target="_blank" 
                                   class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            @endif
                            @if(!empty($data['socials']['twitter']))
                                <a href="{{ $data['socials']['twitter'] }}" target="_blank" 
                                   class="w-10 h-10 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                            @endif
                            @if(!empty($data['socials']['personal_website']))
                                <a href="{{ $data['socials']['personal_website'] }}" target="_blank" 
                                   class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Bio --}}
                @if($data['bio'])
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $data['bio'] }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- About Me --}}
                @if($data['about_me'])
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Me</h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $data['about_me'] }}</p>
                    </div>
                @endif

                {{-- Experience --}}
                @if(count($data['experiences']) > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Experience</h2>
                        <div class="space-y-6">
                            @foreach($data['experiences'] as $experience)
                                <div class="border-l-4 border-indigo-500 pl-4">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $experience['title'] }}</h3>
                                    <p class="text-indigo-600 font-medium">{{ $experience['company'] }}</p>
                                    <p class="text-gray-600 text-sm mt-1">
                                        {{ $experience['start_date'] }} - {{ $experience['end_date'] ?? 'Present' }}
                                        @if($experience['location'])
                                            • {{ $experience['location'] }}
                                        @endif
                                    </p>
                                    @if($experience['description'])
                                        <p class="text-gray-700 mt-2">{{ $experience['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Projects --}}
                @if(count($data['projects']) > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Projects</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($data['projects'] as $project)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    @if($project['image_path'])
                                        <img src="{{ $project['image_path'] }}" 
                                             alt="{{ $project['title'] }}" 
                                             class="w-full h-40 object-cover rounded-lg mb-3">
                                    @endif
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $project['title'] }}</h3>
                                    <p class="text-gray-600 text-sm mt-2">{{ $project['description'] }}</p>
                                    @if($project['url'])
                                        <a href="{{ $project['url'] }}" target="_blank" 
                                           class="inline-block mt-3 text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                            View Project →
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Education --}}
                @if(count($data['education']) > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Education</h2>
                        <div class="space-y-6">
                            @foreach($data['education'] as $edu)
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $edu['degree'] }}</h3>
                                    <p class="text-purple-600 font-medium">{{ $edu['school'] }}</p>
                                    @if($edu['field_of_study'])
                                        <p class="text-gray-700">{{ $edu['field_of_study'] }}</p>
                                    @endif
                                    <p class="text-gray-600 text-sm mt-1">
                                        {{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}
                                    </p>
                                    @if($edu['description'])
                                        <p class="text-gray-700 mt-2">{{ $edu['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                
                {{-- Skills --}}
                @if(count($data['skills']) > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($data['skills'] as $skill)
                                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Contact Info --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact</h2>
                    <div class="space-y-3">
                        @if($data['email'])
                            <a href="mailto:{{ $data['email'] }}" 
                               class="flex items-center text-gray-700 hover:text-indigo-600 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $data['email'] }}
                            </a>
                        @endif
                        @if($data['location'])
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $data['location'] }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Stats --}}
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <h2 class="text-xl font-bold mb-4">Profile Stats</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span>API Requests</span>
                            <span class="text-2xl font-bold">{{ number_format($data['api_request_count']) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Projects</span>
                            <span class="text-2xl font-bold">{{ count($data['projects']) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Skills</span>
                            <span class="text-2xl font-bold">{{ count($data['skills']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>