<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    <meta name="description" content="{{ $data['bio'] }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold">{{ $data['name'] }}</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->avatar() }}" alt="Avatar">
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="p-4">
                                    <div class="flex items-center space-x-3">
                                        <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->avatar() }}" alt="Avatar">
                                        <div>
                                            <p class="font-medium">{{ Auth::user()->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->username }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth
                    
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i class="bi bi-sun" x-show="!darkMode"></i>
                            <i class="bi bi-moon" x-show="darkMode"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <div class="p-2">
                                <button @click="darkMode = false; open = false" class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <i class="bi bi-sun"></i>
                                    <span>Light</span>
                                </button>
                                <button @click="darkMode = true; open = false" class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <i class="bi bi-moon"></i>
                                    <span>Dark</span>
                                </button>
                                <button @click="darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches; localStorage.removeItem('theme'); open = false" class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <i class="bi bi-circle-half"></i>
                                    <span>System</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="text-center mb-12">
            <div class="mb-6">
                <img class="w-32 h-32 rounded-full mx-auto object-cover shadow-lg" src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}">
            </div>
            <h1 class="text-4xl font-bold mb-2">{{ $data['name'] }}</h1>
            <h2 class="text-xl text-indigo-600 dark:text-indigo-400 mb-4">{{ $data['title'] }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4 max-w-2xl mx-auto">{{ $data['bio'] }}</p>
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center space-x-1">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $data['location'] }}</span>
                </div>
                <div class="flex items-center space-x-1">
                    <i class="bi bi-envelope"></i>
                    <a href="mailto:{{ $data['email'] }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">{{ $data['email'] }}</a>
                </div>
            </div>
        </header>

        @if(!empty($data['socials']) && array_filter($data['socials']))
        <section class="mb-12">
            <div class="flex justify-center space-x-6">
                @if($data['socials']['github'])
                    <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                        <i class="bi bi-github text-2xl"></i>
                    </a>
                @endif
                @if($data['socials']['linkedin'])
                    <a href="https://linkedin.com/in/{{ $data['socials']['linkedin'] }}" target="_blank" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i class="bi bi-linkedin text-2xl"></i>
                    </a>
                @endif
                @if($data['socials']['twitter'])
                    <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank" class="text-gray-600 hover:text-blue-400 dark:text-gray-400 dark:hover:text-blue-300">
                        <i class="bi bi-twitter text-2xl"></i>
                    </a>
                @endif
                @if($data['socials']['personal_website'])
                    <a href="{{ $data['socials']['personal_website'] }}" target="_blank" class="text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                        <i class="bi bi-globe text-2xl"></i>
                    </a>
                @endif
            </div>
        </section>
        @endif

        @if(!empty($data['skills']))
        <section class="mb-12">
            <h3 class="text-2xl font-bold mb-6">Skills</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($data['skills'] as $skill)
                    <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full text-sm">{{ $skill }}</span>
                @endforeach
            </div>
        </section>
        @endif

        @if(!empty($data['projects']))
        <section class="mb-12">
            <h3 class="text-2xl font-bold mb-6">Projects</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($data['projects'] as $project)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        @if($project['image_path'])
                            <img class="w-full h-48 object-cover rounded-md mb-4" src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}">
                        @endif
                        <h4 class="text-lg font-semibold mb-2">{{ $project['title'] }}</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $project['description'] }}</p>
                        @if($project['url'])
                            <a href="{{ $project['url'] }}" target="_blank" class="inline-flex items-center space-x-1 text-indigo-600 dark:text-indigo-400 hover:underline">
                                <span>View Project</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        @if(!empty($data['experiences']))
        <section class="mb-12">
            <h3 class="text-2xl font-bold mb-6">Experience</h3>
            <div class="space-y-6">
                @foreach($data['experiences'] as $experience)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-2">
                            <div>
                                <h4 class="text-lg font-semibold">{{ $experience['title'] }}</h4>
                                <p class="text-indigo-600 dark:text-indigo-400">{{ $experience['company'] }}</p>
                                @if($experience['location'])
                                    <p class="text-gray-500 dark:text-gray-400">{{ $experience['location'] }}</p>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-0">
                                {{ \Carbon\Carbon::parse($experience['start_date'])->format('M Y') }} - 
                                {{ \Carbon\Carbon::parse($experience['end_date'])->format('M Y') }}
                            </div>
                        </div>
                        @if($experience['description'])
                            <p class="text-gray-600 dark:text-gray-300">{{ $experience['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        @if(!empty($data['education']))
        <section class="mb-12">
            <h3 class="text-2xl font-bold mb-6">Education</h3>
            <div class="space-y-6">
                @foreach($data['education'] as $edu)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-2">
                            <div>
                                <h4 class="text-lg font-semibold">{{ $edu['degree'] }}</h4>
                                <p class="text-indigo-600 dark:text-indigo-400">{{ $edu['school'] }}</p>
                                @if($edu['field_of_study'])
                                    <p class="text-gray-500 dark:text-gray-400">{{ $edu['field_of_study'] }}</p>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-0">
                                {{ \Carbon\Carbon::parse($edu['start_date'])->format('M Y') }} - 
                                {{ \Carbon\Carbon::parse($edu['end_date'])->format('M Y') }}
                            </div>
                        </div>
                        @if($edu['description'])
                            <p class="text-gray-600 dark:text-gray-300">{{ $edu['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
        @endif
    </main>

    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 dark:text-gray-400">
                <p>Powered by <a href="https://getmy.name" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">getmy.name</a> from <a href="https://mtex.dev" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">mtex.dev</a></p>
            </div>
        </div>
    </footer>
</body>
</html>