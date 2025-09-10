<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - {{ $data['title'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/90 backdrop-blur-sm shadow-sm z-50 border-b">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="w-10 h-10 rounded-full object-cover">
                    <span class="font-bold text-xl text-gray-900">{{ $data['username'] }}</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#about" class="text-gray-600 hover:text-blue-600 transition-colors">About</a>
                    <a href="#skills" class="text-gray-600 hover:text-blue-600 transition-colors">Skills</a>
                    <a href="#experience" class="text-gray-600 hover:text-blue-600 transition-colors">Experience</a>
                    <a href="#projects" class="text-gray-600 hover:text-blue-600 transition-colors">Projects</a>
                    <a href="#contact" class="text-gray-600 hover:text-blue-600 transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                        Hello, I'm <span class="text-blue-600">{{ $data['name'] }}</span>
                    </h1>
                    <h2 class="text-2xl lg:text-3xl text-gray-600 mb-6">{{ $data['title'] }}</h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">{{ $data['about_me'] }}</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#contact" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Get In Touch
                        </a>
                        <a href="#projects" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                            View Projects
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center lg:justify-end">
                    <div class="relative">
                        <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="w-80 h-80 rounded-full object-cover shadow-2xl">
                        <div class="absolute -bottom-6 -right-6 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $data['location'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Skills & Technologies</h2>
                <p class="text-lg text-gray-600">Technologies I work with</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                @foreach($data['skills'] as $skill)
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-code text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">{{ $skill }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Work Experience</h2>
                <p class="text-lg text-gray-600">My professional journey</p>
            </div>
            <div class="max-w-4xl mx-auto">
                @foreach($data['experiences'] as $experience)
                <div class="bg-white rounded-lg shadow-md p-8 mb-6 border-l-4 border-blue-600">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $experience['title'] }}</h3>
                            <h4 class="text-xl text-blue-600 mb-2">{{ $experience['company'] }}</h4>
                            @if($experience['location'])
                            <p class="text-gray-600 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $experience['location'] }}
                            </p>
                            @endif
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ date('M Y', strtotime($experience['start_date'])) }} - 
                            {{ date('M Y', strtotime($experience['end_date'])) }}
                        </div>
                    </div>
                    @if($experience['description'])
                    <p class="text-gray-700 leading-relaxed">{{ $experience['description'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section id="education" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Education</h2>
                <p class="text-lg text-gray-600">My academic background</p>
            </div>
            <div class="max-w-4xl mx-auto">
                @foreach($data['education'] as $education)
                <div class="bg-gray-50 rounded-lg p-8 mb-6 border-l-4 border-green-600">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $education['degree'] }}</h3>
                            <h4 class="text-xl text-green-600 mb-2">{{ $education['school'] }}</h4>
                            <p class="text-gray-600">{{ $education['field_of_study'] }}</p>
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ date('M Y', strtotime($education['start_date'])) }} - 
                            {{ date('M Y', strtotime($education['end_date'])) }}
                        </div>
                    </div>
                    @if($education['description'])
                    <p class="text-gray-700 leading-relaxed">{{ $education['description'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured Projects</h2>
                <p class="text-lg text-gray-600">Some of my recent work</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8">
                @foreach($data['projects'] as $project)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($project['image_path'])
                    <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-code text-white text-4xl"></i>
                    </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $project['title'] }}</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ $project['description'] }}</p>
                        <a href="{{ $project['url'] }}" target="_blank" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                            View Project <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Let's Connect</h2>
                <p class="text-lg text-gray-600">Feel free to reach out for collaborations or just a friendly hello</p>
            </div>
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-600 w-6 mr-4"></i>
                                <a href="mailto:{{ $data['email'] }}" class="text-gray-700 hover:text-blue-600">{{ $data['email'] }}</a>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-600 w-6 mr-4"></i>
                                <span class="text-gray-700">{{ $data['location'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Follow Me</h3>
                        <div class="flex space-x-4">
                            @if($data['socials']['github'])
                            <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank" 
                               class="bg-gray-800 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors">
                                <i class="fab fa-github"></i>
                            </a>
                            @endif
                            @if($data['socials']['linkedin'])
                            <a href="https://linkedin.com/in/{{ $data['socials']['linkedin'] }}" target="_blank" 
                               class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if($data['socials']['twitter'])
                            <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank" 
                               class="bg-blue-400 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                            @if($data['socials']['personal_website'])
                            <a href="{{ $data['socials']['personal_website'] }}" target="_blank" 
                               class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                                <i class="fas fa-globe"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} {{ $data['name'] }}. All rights reserved.</p>
            <p class="text-gray-400 text-sm mt-2">Built with Laravel & TailwindCSS</p>
        </div>
    </footer>

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>