<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
        
        * {
            image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
        
        body {
            font-family: 'Press Start 2P', monospace;
            background-color: #0a0e27;
            color: #00ff41;
            line-height: 1.8;
        }
        
        .pixel-border {
            border: 4px solid;
            border-image: repeating-linear-gradient(
                90deg,
                currentColor 0px, currentColor 4px,
                transparent 4px, transparent 8px
            ) 4;
        }
        
        .pixel-box {
            background-color: #1a1f3a;
            border: 3px solid #00ff41;
            box-shadow: 
                0 0 0 1px #0a0e27,
                4px 4px 0 0 #00ff41;
            position: relative;
        }
        
        .pixel-box::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: 
                linear-gradient(90deg, #00ff41 2px, transparent 2px),
                linear-gradient(180deg, #00ff41 2px, transparent 2px);
            background-size: 8px 8px;
            pointer-events: none;
            opacity: 0.1;
        }
        
        .pixel-btn {
            background-color: #00ff41;
            color: #0a0e27;
            border: 3px solid #00ff41;
            padding: 8px 16px;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.1s;
            text-transform: uppercase;
        }
        
        .pixel-btn:hover {
            background-color: #0a0e27;
            color: #00ff41;
            box-shadow: 4px 4px 0 0 #00ff41;
            transform: translate(-2px, -2px);
        }
        
        .pixel-btn:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }
        
        .glitch {
            position: relative;
            animation: glitch 3s infinite;
        }
        
        @keyframes glitch {
            0%, 90%, 100% { transform: translate(0); }
            91% { transform: translate(-2px, 2px); }
            92% { transform: translate(2px, -2px); }
            93% { transform: translate(-2px, -2px); }
            94% { transform: translate(2px, 2px); }
        }
        
        .popover {
            display: none;
            position: absolute;
            z-index: 1000;
            background-color: #1a1f3a;
            border: 3px solid #ff00ff;
            padding: 16px;
            min-width: 250px;
            box-shadow: 6px 6px 0 0 #ff00ff;
            animation: popIn 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        @keyframes popIn {
            0% { transform: scale(0) rotate(-5deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        
        .popover.active {
            display: block;
        }
        
        .pixel-avatar {
            width: 128px;
            height: 128px;
            border: 4px solid #00ff41;
            box-shadow: 
                inset 0 0 0 2px #0a0e27,
                8px 8px 0 0 #00ff41;
        }
        
        .skill-tag {
            display: inline-block;
            background-color: #ff00ff;
            color: #0a0e27;
            padding: 6px 12px;
            margin: 4px;
            font-size: 8px;
            border: 2px solid #ff00ff;
            cursor: pointer;
            transition: all 0.1s;
        }
        
        .skill-tag:hover {
            background-color: #0a0e27;
            color: #ff00ff;
            box-shadow: 3px 3px 0 0 #ff00ff;
        }
        
        .project-card {
            background-color: #1a1f3a;
            border: 3px solid #00ffff;
            padding: 20px;
            margin-bottom: 16px;
            position: relative;
            transition: all 0.2s;
        }
        
        .project-card:hover {
            box-shadow: 6px 6px 0 0 #00ffff;
            transform: translate(-3px, -3px);
            border-color: #ff00ff;
        }
        
        .project-card::after {
            content: '▶';
            position: absolute;
            top: 12px;
            right: 12px;
            color: #00ffff;
            font-size: 12px;
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 49% { opacity: 1; }
            50%, 100% { opacity: 0; }
        }
        
        .timeline-item {
            border-left: 4px solid #00ff41;
            padding-left: 20px;
            margin-bottom: 24px;
            position: relative;
        }
        
        .timeline-item::before {
            content: '●';
            position: absolute;
            left: -10px;
            top: 0;
            color: #00ff41;
            font-size: 16px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
        }
        
        .scanline {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #00ff41;
            opacity: 0.1;
            animation: scan 4s linear infinite;
            pointer-events: none;
            z-index: 9999;
        }
        
        @keyframes scan {
            0% { transform: translateY(0); }
            100% { transform: translateY(100vh); }
        }
        
        h1, h2, h3 {
            color: #00ffff;
            text-shadow: 2px 2px 0 #ff00ff;
        }
        
        a {
            color: #ff00ff;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: border-color 0.2s;
        }
        
        a:hover {
            border-bottom-color: #ff00ff;
        }
        
        .social-link {
            display: inline-block;
            margin: 8px;
            padding: 12px;
            background-color: #00ff41;
            color: #0a0e27;
            border: 3px solid #00ff41;
            font-size: 10px;
            transition: all 0.1s;
        }
        
        .social-link:hover {
            background-color: #0a0e27;
            color: #00ff41;
            box-shadow: 4px 4px 0 0 #00ff41;
            transform: translate(-2px, -2px);
        }
        
        .stat-counter {
            font-size: 24px;
            color: #00ffff;
            text-shadow: 3px 3px 0 #ff00ff;
        }
    </style>
</head>
<body class="p-4 md:p-8">
    <div class="scanline"></div>
    
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <header class="pixel-box p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <img src="{{ $data['avatar_url'] }}" 
                     alt="{{ $data['name'] }}" 
                     class="pixel-avatar">
                
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl md:text-4xl mb-4 glitch">{{ $data['name'] }}</h1>
                    <p class="text-sm md:text-base mb-2 text-white">{{ $data['title'] }}</p>
                    @if($data['location'])
                        <p class="text-xs mb-4 text-gray-400">📍 {{ $data['location'] }}</p>
                    @endif
                    <p class="text-xs leading-relaxed text-gray-300">{{ $data['bio'] }}</p>
                </div>
                
                <div class="text-center">
                    <div class="text-xs mb-2 text-gray-400">API REQUESTS</div>
                    <div class="stat-counter">{{ number_format($data['api_request_count']) }}</div>
                </div>
            </div>
        </header>

        <!-- About Me Section -->
        @if($data['about_me'])
        <section class="pixel-box p-6 mb-8">
            <h2 class="text-xl mb-4">[ABOUT.TXT]</h2>
            <p class="text-xs leading-loose text-gray-300">{{ $data['about_me'] }}</p>
        </section>
        @endif

        <!-- Skills Section -->
        @if(count($data['skills']) > 0)
        <section class="pixel-box p-6 mb-8">
            <h2 class="text-xl mb-4">[SKILLS.EXE]</h2>
            <div class="flex flex-wrap">
                @foreach($data['skills'] as $skill)
                <span class="skill-tag">{{ strtoupper($skill) }}</span>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Projects Section -->
        @if(count($data['projects']) > 0)
        <section class="pixel-box p-6 mb-8">
            <h2 class="text-xl mb-6">[PROJECTS.DIR]</h2>
            <div class="space-y-4">
                @foreach($data['projects'] as $project)
                <div class="project-card" 
                     onmouseenter="showPopover('project-{{ $project['id'] }}')" 
                     onmouseleave="hidePopover('project-{{ $project['id'] }}')">
                    <h3 class="text-base mb-3">{{ strtoupper($project['title']) }}</h3>
                    <p class="text-xs mb-3 text-gray-300">{{ $project['description'] }}</p>
                    @if($project['url'])
                    <a href="{{ $project['url'] }}" class="pixel-btn" target="_blank">LAUNCH</a>
                    @endif
                    
                    @if($project['image_path'])
                    <div id="project-{{ $project['id'] }}" class="popover">
                        <img src="{{ $project['image_path'] }}" 
                             alt="{{ $project['title'] }}"
                             style="max-width: 200px; border: 2px solid #ff00ff;">
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Experience Section -->
        @if(count($data['experiences']) > 0)
        <section class="pixel-box p-6 mb-8">
            <h2 class="text-xl mb-6">[EXPERIENCE.LOG]</h2>
            @foreach($data['experiences'] as $exp)
            <div class="timeline-item">
                <h3 class="text-sm mb-2">{{ strtoupper($exp['title']) }}</h3>
                <p class="text-xs mb-2 text-purple-400">{{ $exp['company'] }} @if($exp['location'])• {{ $exp['location'] }}@endif</p>
                <p class="text-xs mb-2 text-gray-500">
                    {{ date('M Y', strtotime($exp['start_date'])) }} - 
                    {{ $exp['end_date'] ? date('M Y', strtotime($exp['end_date'])) : 'PRESENT' }}
                </p>
                <p class="text-xs text-gray-300">{{ $exp['description'] }}</p>
            </div>
            @endforeach
        </section>
        @endif

        <!-- Education Section -->
        @if(count($data['education']) > 0)
        <section class="pixel-box p-6 mb-8">
            <h2 class="text-xl mb-6">[EDUCATION.DAT]</h2>
            @foreach($data['education'] as $edu)
            <div class="timeline-item">
                <h3 class="text-sm mb-2">{{ strtoupper($edu['degree']) }}</h3>
                <p class="text-xs mb-2 text-purple-400">{{ $edu['school'] }}</p>
                @if($edu['field_of_study'])
                <p class="text-xs mb-2 text-cyan-400">{{ $edu['field_of_study'] }}</p>
                @endif
                <p class="text-xs mb-2 text-gray-500">
                    {{ date('Y', strtotime($edu['start_date'])) }} - 
                    {{ $edu['end_date'] ? date('Y', strtotime($edu['end_date'])) : 'PRESENT' }}
                </p>
                @if($edu['description'])
                <p class="text-xs text-gray-300">{{ $edu['description'] }}</p>
                @endif
            </div>
            @endforeach
        </section>
        @endif

        <!-- Social Links -->
        @if($data['socials'])
        <section class="pixel-box p-6 mb-8 text-center">
            <h2 class="text-xl mb-6">[CONNECT.SYS]</h2>
            <div class="flex flex-wrap justify-center gap-2">
                @if(isset($data['socials']['github']))
                <a href="{{ $data['socials']['github'] }}" class="social-link" target="_blank">GITHUB</a>
                @endif
                @if(isset($data['socials']['linkedin']))
                <a href="{{ $data['socials']['linkedin'] }}" class="social-link" target="_blank">LINKEDIN</a>
                @endif
                @if(isset($data['socials']['twitter']))
                <a href="{{ $data['socials']['twitter'] }}" class="social-link" target="_blank">TWITTER</a>
                @endif
                @if(isset($data['socials']['personal_website']))
                <a href="{{ $data['socials']['personal_website'] }}" class="social-link" target="_blank">WEBSITE</a>
                @endif
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="text-center text-xs text-gray-600 py-8">
            <p>{{ strtoupper($data['username']) }}.PROFILE // SYSTEM.ONLINE</p>
        </footer>
    </div>

    <script>
        function showPopover(id) {
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
    </script>
</body>
</html>