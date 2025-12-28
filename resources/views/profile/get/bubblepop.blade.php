<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes wiggle {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }
        
        @keyframes pop {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .wiggle-hover:hover {
            animation: wiggle 0.5s ease-in-out;
        }

        .pop-hover:hover {
            animation: pop 0.3s ease-in-out;
        }

        .blob {
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }

        .blob-2 {
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        }

        .blob-3 {
            border-radius: 40% 60% 70% 30% / 40% 70% 30% 60%;
        }

        .wavy-border {
            position: relative;
        }

        .wavy-border::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: #3b82f6;
            border-radius: inherit;
            z-index: -1;
        }

        .tag-cloud span {
            display: inline-block;
            transition: all 0.3s ease;
        }

        .tag-cloud span:hover {
            transform: scale(1.2) rotate(5deg);
        }

        .project-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .project-card:hover {
            transform: translateY(-8px);
        }

        .doodle {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-yellow-50 min-h-screen relative overflow-x-hidden">
    <!-- Decorative Doodles -->
    <div class="doodle top-10 left-10 text-9xl">✨</div>
    <div class="doodle top-40 right-20 text-7xl float-animation">🎨</div>
    <div class="doodle bottom-20 left-1/4 text-8xl float-animation" style="animation-delay: 1s;">🚀</div>
    <div class="doodle bottom-40 right-1/3 text-6xl float-animation" style="animation-delay: 2s;">⚡</div>

    <div class="container mx-auto px-4 py-12 max-w-6xl relative z-10">
        <!-- Header Section -->
        <header class="text-center mb-16">
            <div class="inline-block float-animation mb-6">
                <div class="relative">
                    <div class="absolute inset-0 blob bg-blue-400 opacity-20 blur-xl"></div>
                    <img src="{{ $data['avatar_url'] }}" 
                         alt="{{ $data['name'] }}" 
                         class="w-40 h-40 rounded-full border-8 border-white shadow-2xl relative z-10 wiggle-hover">
                </div>
            </div>
            
            <h1 class="text-6xl font-black text-gray-900 mb-3 wiggle-hover inline-block">
                {{ $data['name'] }}
            </h1>
            
            @if($data['title'])
                <p class="text-2xl text-blue-600 font-bold mb-4">{{ $data['title'] }}</p>
            @endif
            
            @if($data['location'])
                <p class="text-lg text-gray-600 mb-4">📍 {{ $data['location'] }}</p>
            @endif
            
            @if($data['bio'])
                <p class="text-xl text-gray-700 max-w-2xl mx-auto leading-relaxed">
                    {{ $data['bio'] }}
                </p>
            @endif

            <!-- Social Links -->
            @if($data['socials'] && count(array_filter($data['socials'])) > 0)
                <div class="flex justify-center gap-4 mt-8">
                    @if($data['socials']['github'] ?? false)
                        <a href="{{ $data['socials']['github'] }}" 
                           class="bg-gray-900 text-white px-6 py-3 rounded-full font-bold pop-hover shadow-lg hover:shadow-2xl transition-shadow">
                            GitHub
                        </a>
                    @endif
                    @if($data['socials']['linkedin'] ?? false)
                        <a href="{{ $data['socials']['linkedin'] }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-full font-bold pop-hover shadow-lg hover:shadow-2xl transition-shadow">
                            LinkedIn
                        </a>
                    @endif
                    @if($data['socials']['twitter'] ?? false)
                        <a href="{{ $data['socials']['twitter'] }}" 
                           class="bg-sky-500 text-white px-6 py-3 rounded-full font-bold pop-hover shadow-lg hover:shadow-2xl transition-shadow">
                            Twitter
                        </a>
                    @endif
                    @if($data['socials']['personal_website'] ?? false)
                        <a href="{{ $data['socials']['personal_website'] }}" 
                           class="bg-purple-600 text-white px-6 py-3 rounded-full font-bold pop-hover shadow-lg hover:shadow-2xl transition-shadow">
                            Website
                        </a>
                    @endif
                </div>
            @endif
        </header>

        <!-- About Me Section -->
        @if($data['about_me'])
            <section class="mb-16">
                <div class="bg-white rounded-3xl p-8 shadow-xl border-4 border-gray-900 wiggle-hover">
                    <h2 class="text-4xl font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="text-5xl">💭</span> About Me
                    </h2>
                    <div class="text-lg text-gray-700 leading-relaxed prose prose-lg max-w-none">
                        {!! nl2br(e($data['about_me'])) !!}
                    </div>
                </div>
            </section>
        @endif

        <!-- Skills Section -->
        @if($data['skills'] && count($data['skills']) > 0)
            <section class="mb-16">
                <div class="bg-pink-100 rounded-3xl p-8 shadow-xl border-4 border-gray-900 wiggle-hover">
                    <h2 class="text-4xl font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="text-5xl">🎯</span> Skills
                    </h2>
                    <div class="tag-cloud flex flex-wrap gap-3">
                        @foreach($data['skills'] as $skill)
                            <span class="bg-white text-gray-900 px-6 py-3 rounded-full font-bold border-3 border-gray-900 shadow-md">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Projects Section -->
        @if($data['projects'] && count($data['projects']) > 0)
            <section class="mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-8 text-center flex items-center justify-center gap-3">
                    <span class="text-5xl">🚀</span> Projects
                </h2>
                <div class="grid md:grid-cols-2 gap-8">
                    @foreach($data['projects'] as $project)
                        <div class="project-card bg-white rounded-3xl overflow-hidden shadow-xl border-4 border-gray-900">
                            @if($project['image_path'])
                                <img src="{{ $project['image_path'] }}" 
                                     alt="{{ $project['title'] }}"
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 blob-2 bg-blue-200 flex items-center justify-center text-6xl">
                                    💡
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-2xl font-black text-gray-900 mb-3">
                                    {{ $project['title'] }}
                                </h3>
                                <p class="text-gray-700 mb-4">
                                    {{ $project['description'] }}
                                </p>
                                @if($project['url'])
                                    <a href="{{ $project['url'] }}" 
                                       class="inline-block bg-blue-500 text-white px-6 py-2 rounded-full font-bold pop-hover">
                                        View Project →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Experience Section -->
        @if($data['experiences'] && count($data['experiences']) > 0)
            <section class="mb-16">
                <div class="bg-green-100 rounded-3xl p-8 shadow-xl border-4 border-gray-900 wiggle-hover">
                    <h2 class="text-4xl font-black text-gray-900 mb-8 flex items-center gap-3">
                        <span class="text-5xl">💼</span> Experience
                    </h2>
                    <div class="space-y-6">
                        @foreach($data['experiences'] as $experience)
                            <div class="bg-white rounded-2xl p-6 border-3 border-gray-900 shadow-md pop-hover">
                                <h3 class="text-2xl font-black text-gray-900">
                                    {{ $experience['title'] }}
                                </h3>
                                <p class="text-lg font-bold text-blue-600 mb-2">
                                    {{ $experience['company'] }}
                                </p>
                                <p class="text-gray-600 mb-2">
                                    {{ $experience['start_date'] }} - {{ $experience['end_date'] ?? 'Present' }}
                                    @if($experience['location'])
                                        • {{ $experience['location'] }}
                                    @endif
                                </p>
                                @if($experience['description'])
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $experience['description'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Education Section -->
        @if($data['education'] && count($data['education']) > 0)
            <section class="mb-16">
                <div class="bg-purple-100 rounded-3xl p-8 shadow-xl border-4 border-gray-900 wiggle-hover">
                    <h2 class="text-4xl font-black text-gray-900 mb-8 flex items-center gap-3">
                        <span class="text-5xl">🎓</span> Education
                    </h2>
                    <div class="space-y-6">
                        @foreach($data['education'] as $edu)
                            <div class="bg-white rounded-2xl p-6 border-3 border-gray-900 shadow-md pop-hover">
                                <h3 class="text-2xl font-black text-gray-900">
                                    {{ $edu['school'] }}
                                </h3>
                                <p class="text-lg font-bold text-purple-600 mb-2">
                                    {{ $edu['degree'] }} @if($edu['field_of_study']) in {{ $edu['field_of_study'] }} @endif
                                </p>
                                <p class="text-gray-600 mb-2">
                                    {{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}
                                </p>
                                @if($edu['description'])
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $edu['description'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Footer -->
        <footer class="text-center mt-16 pb-8">
            <div class="inline-block bg-orange-200 rounded-full px-8 py-4 border-4 border-gray-900 shadow-lg wiggle-hover">
                <p class="text-gray-900 font-bold">
                    ✨ Thanks for visiting! ✨
                </p>
            </div>
        </footer>
    </div>
</body>
</html>