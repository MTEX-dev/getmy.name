<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }

        body {
            background-color: #0a0e27;
            color: #e0e0e0;
            font-family: 'Courier New', monospace;
        }

        .pixel-border {
            position: relative;
            background: #1a1f3a;
        }

        .pixel-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 3px;
            background: linear-gradient(45deg, #00ff88, #00d4ff, #ff00ff, #ffaa00);
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.8;
        }

        .pixel-corner {
            clip-path: polygon(
                0 8px, 8px 8px, 8px 0,
                calc(100% - 8px) 0, calc(100% - 8px) 8px, 100% 8px,
                100% calc(100% - 8px), calc(100% - 8px) calc(100% - 8px), calc(100% - 8px) 100%,
                8px 100%, 8px calc(100% - 8px), 0 calc(100% - 8px)
            );
        }

        .pixelated-shadow {
            box-shadow: 
                4px 0 0 #00ff88,
                0 4px 0 #00ff88,
                4px 4px 0 #00ff88,
                8px 8px 0 rgba(0, 255, 136, 0.5);
        }

        .neon-text {
            text-shadow: 
                0 0 10px currentColor,
                0 0 20px currentColor,
                0 0 30px currentColor;
        }

        .popover {
            display: none;
            position: absolute;
            z-index: 50;
            background: #1a1f3a;
            border: 3px solid #00ff88;
            padding: 16px;
            min-width: 250px;
            animation: pixelPop 0.3s steps(5);
        }

        .popover.active {
            display: block;
        }

        @keyframes pixelPop {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        .blink {
            animation: blink 1s infinite;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .pixel-btn {
            position: relative;
            padding: 12px 24px;
            background: #1a1f3a;
            border: 3px solid #00ff88;
            color: #00ff88;
            cursor: pointer;
            transition: all 0.1s;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .pixel-btn:hover {
            background: #00ff88;
            color: #0a0e27;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 rgba(0, 255, 136, 0.5);
        }

        .pixel-btn:active {
            transform: translate(0, 0);
            box-shadow: none;
        }

        .skill-tag {
            display: inline-block;
            padding: 6px 12px;
            background: #1a1f3a;
            border: 2px solid #00d4ff;
            color: #00d4ff;
            margin: 4px;
            font-size: 12px;
            transition: all 0.2s;
        }

        .skill-tag:hover {
            background: #00d4ff;
            color: #0a0e27;
            transform: scale(1.05);
        }

        .project-card {
            background: #1a1f3a;
            border: 3px solid #ff00ff;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .project-card:hover {
            border-color: #00ff88;
            transform: translateY(-4px);
        }

        .scanline {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.15),
                rgba(0, 0, 0, 0.15) 1px,
                transparent 1px,
                transparent 2px
            );
            pointer-events: none;
            z-index: 100;
        }

        .grid-bg {
            background-image: 
                linear-gradient(rgba(0, 255, 136, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 136, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .avatar-pixel {
            width: 120px;
            height: 120px;
            border: 4px solid #00ff88;
            image-rendering: pixelated;
            box-shadow: 
                4px 4px 0 rgba(0, 255, 136, 0.5),
                8px 8px 0 rgba(0, 255, 136, 0.3);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: #1a1f3a;
            border: 2px solid #00d4ff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 4px;
            transition: all 0.2s;
            color: #00d4ff;
            text-decoration: none;
        }

        .social-icon:hover {
            background: #00d4ff;
            color: #0a0e27;
            transform: scale(1.1);
        }
    </style>
</head>
<body class="grid-bg">
    <div class="scanline"></div>
    
    <div class="max-w-6xl mx-auto p-6">
        <!-- Header Section -->
        <header class="mb-12 slide-in">
            <div class="pixel-border pixel-corner p-8 mb-8">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative">
                        <img src="{{ $data['avatar_url'] }}" 
                             alt="{{ $data['name'] }}" 
                             class="avatar-pixel">
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-[#00ff88] blink"></div>
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl font-bold mb-2 neon-text text-[#00ff88]">
                            {{ $data['name'] }}
                        </h1>
                        <p class="text-xl text-[#00d4ff] mb-3">{{ $data['title'] }}</p>
                        <p class="text-sm text-gray-400 mb-4">
                            <span class="text-[#ffaa00]">{{ '@' . $data['username'] }}</span>
                            @if($data['location'])
                                <span class="mx-2">|</span>
                                <span>📍 {{ $data['location'] }}</span>
                            @endif
                        </p>
                        <p class="text-base leading-relaxed">{{ $data['bio'] }}</p>
                    </div>

                    <!-- Social Links -->
                    @if($data['socials'] && count(array_filter($data['socials'])) > 0)
                    <div class="flex flex-wrap justify-center md:justify-start gap-2">
                        @if(!empty($data['socials']['github']))
                        <a href="{{ $data['socials']['github'] }}" class="social-icon" target="_blank" rel="noopener">
                            GH
                        </a>
                        @endif
                        @if(!empty($data['socials']['linkedin']))
                        <a href="{{ $data['socials']['linkedin'] }}" class="social-icon" target="_blank" rel="noopener">
                            LI
                        </a>
                        @endif
                        @if(!empty($data['socials']['twitter']))
                        <a href="{{ $data['socials']['twitter'] }}" class="social-icon" target="_blank" rel="noopener">
                            TW
                        </a>
                        @endif
                        @if(!empty($data['socials']['personal_website']))
                        <a href="{{ $data['socials']['personal_website'] }}" class="social-icon" target="_blank" rel="noopener">
                            WEB
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- About Me Section -->
        @if($data['about_me'])
        <section class="mb-12 slide-in" style="animation-delay: 0.1s;">
            <h2 class="text-2xl font-bold mb-4 text-[#ff00ff] flex items-center gap-2">
                <span class="w-3 h-3 bg-[#ff00ff] inline-block"></span>
                ABOUT_ME.txt
            </h2>
            <div class="pixel-border pixel-corner p-6 bg-[#0f1324]">
                <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $data['about_me'] }}</p>
            </div>
        </section>
        @endif

        <!-- Skills Section -->
        @if(count($data['skills']) > 0)
        <section class="mb-12 slide-in" style="animation-delay: 0.2s;">
            <h2 class="text-2xl font-bold mb-4 text-[#00d4ff] flex items-center gap-2">
                <span class="w-3 h-3 bg-[#00d4ff] inline-block"></span>
                SKILLS.dat
            </h2>
            <div class="pixel-border pixel-corner p-6">
                <div class="flex flex-wrap">
                    @foreach($data['skills'] as $skill)
                    <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Projects Section -->
        @if(count($data['projects']) > 0)
        <section class="mb-12 slide-in" style="animation-delay: 0.3s;">
            <h2 class="text-2xl font-bold mb-4 text-[#ffaa00] flex items-center gap-2">
                <span class="w-3 h-3 bg-[#ffaa00] inline-block"></span>
                PROJECTS.exe
            </h2>
            <div class="space-y-6">
                @foreach($data['projects'] as $project)
                <div class="project-card pixel-corner relative">
                    <div class="flex flex-col md:flex-row gap-4">
                        @if($project['image_path'])
                        <div class="w-full md:w-48 h-32 overflow-hidden border-2 border-[#00ff88]">
                            <img src="{{ $project['image_path'] }}" 
                                 alt="{{ $project['title'] }}"
                                 class="w-full h-full object-cover">
                        </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-xl font-bold mb-2 text-[#00ff88]">{{ $project['title'] }}</h3>
                            <p class="text-gray-300 mb-3">{{ $project['description'] }}</p>
                            @if($project['url'])
                            <a href="{{ $project['url'] }}" 
                               class="pixel-btn inline-block text-sm"
                               target="_blank" 
                               rel="noopener">
                                VIEW PROJECT →
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Experience Section -->
        @if(count($data['experiences']) > 0)
        <section class="mb-12 slide-in" style="animation-delay: 0.4s;">
            <h2 class="text-2xl font-bold mb-4 text-[#ff00ff] flex items-center gap-2">
                <span class="w-3 h-3 bg-[#ff00ff] inline-block"></span>
                EXPERIENCE.log
            </h2>
            <div class="space-y-4">
                @foreach($data['experiences'] as $experience)
                <div class="pixel-border pixel-corner p-6 bg-[#0f1324] relative group cursor-pointer"
                     onmouseenter="showPopover(event, 'exp-{{ $experience['id'] }}')"
                     onmouseleave="hidePopover('exp-{{ $experience['id'] }}')">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-lg font-bold text-[#00ff88]">{{ $experience['title'] }}</h3>
                            <p class="text-[#00d4ff]">{{ $experience['company'] }}</p>
                        </div>
                        <div class="text-right text-sm text-gray-400">
                            <p>{{ $experience['start_date'] }} - {{ $experience['end_date'] ?? 'Present' }}</p>
                            @if($experience['location'])
                            <p>{{ $experience['location'] }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Popover -->
                    @if($experience['description'])
                    <div id="exp-{{ $experience['id'] }}" class="popover pixel-corner mt-4">
                        <p class="text-gray-300 text-sm">{{ $experience['description'] }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Education Section -->
        @if(count($data['education']) > 0)
        <section class="mb-12 slide-in" style="animation-delay: 0.5s;">
            <h2 class="text-2xl font-bold mb-4 text-[#00d4ff] flex items-center gap-2">
                <span class="w-3 h-3 bg-[#00d4ff] inline-block"></span>
                EDUCATION.db
            </h2>
            <div class="space-y-4">
                @foreach($data['education'] as $edu)
                <div class="pixel-border pixel-corner p-6 bg-[#0f1324]">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-lg font-bold text-[#00ff88]">{{ $edu['degree'] }}</h3>
                            <p class="text-[#00d4ff]">{{ $edu['school'] }}</p>
                            @if($edu['field_of_study'])
                            <p class="text-sm text-gray-400">{{ $edu['field_of_study'] }}</p>
                            @endif
                        </div>
                        <div class="text-right text-sm text-gray-400">
                            <p>{{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}</p>
                        </div>
                    </div>
                    @if($edu['description'])
                    <p class="text-gray-300 text-sm mt-3">{{ $edu['description'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="text-center py-8 text-gray-500 text-sm">
            <p class="mb-2">
                <span class="text-[#00ff88]">▓▓▓▓▓▓▓▓▓▓</span> 
                PROFILE_LOADED 
                <span class="text-[#00ff88]">▓▓▓▓▓▓▓▓▓▓</span>
            </p>
            <p>API Requests: <span class="text-[#00d4ff]">{{ $data['api_request_count'] }}</span></p>
        </footer>
    </div>

    <script>
        function showPopover(event, id) {
            const popover = document.getElementById(id);
            if (popover) {
                popover.classList.add('active');
            }
        }

        function hidePopover(id) {
            const popover = document.getElementById(id);
            if (popover) {
                popover.classList.remove('active');
            }
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }
            });
        });

        document.querySelectorAll('.slide-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>