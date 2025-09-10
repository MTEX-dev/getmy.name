<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $title = ($data['name'] ?? 'User') . ' - Windows XP Portfolio';
        $description = $data['bio'] ?? 'A portfolio presented in classic Windows XP style.';
        $imageUrl = $data['avatar_url'] ?? asset('images/default-avatar.jpg');
    @endphp
    <title>{{ $title }}</title>

    <meta name="description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $imageUrl }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image" content="{{ $imageUrl }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tahoma:wght@400;700&display=swap');

        :root {
            --xp-blue: #0078d4;
            --xp-light-blue: #316AC5;
            --xp-dark-blue: #1941A5;
            --xp-green: #73D216;
            --xp-orange: #FF6B35;
            --xp-gray: #ECE9D8;
            --xp-dark-gray: #D4D0C8;
            --xp-light-gray: #F4F3EE;
            --xp-border-dark: #ACA899;
            --xp-border-light: #FFFFFF;
            --window-bg: #ECE9D8;
            --taskbar-bg: #245EDC;
            --taskbar-gradient: linear-gradient(to bottom, #245EDC 0%, #1941A5 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tahoma', sans-serif;
        }

        body {
            background: linear-gradient(45deg, #0078d4, #316AC5);
            min-height: 100vh;
            overflow: hidden;
            cursor: default;
            user-select: none;
        }

        .desktop {
            position: relative;
            width: 100vw;
            height: 100vh;
            background-image:
                radial-gradient(ellipse at center, rgba(255,255,255,0.1) 0%, transparent 50%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="60" r="1" fill="rgba(255,255,255,0.08)"/><circle cx="40" cy="80" r="1.5" fill="rgba(255,255,255,0.06)"/></svg>');
            display: flex;
            flex-direction: column;
        }

        .desktop-icons {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1;
        }

        .desktop-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            text-align: center;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            transition: background-color 0.2s;
        }

        .desktop-icon:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .desktop-icon.active {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .desktop-icon img {
            width: 32px;
            height: 32px;
            display: block;
            margin: 0 auto 5px;
        }

        .desktop-icon span {
            color: white;
            font-size: 11px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            display: block;
            line-height: 1.2;
        }

        .windows-container {
            position: relative;
            flex: 1;
            overflow: hidden;
        }

        .window {
            position: absolute;
            background: var(--window-bg);
            border: 2px outset var(--xp-border-light);
            border-radius: 8px 8px 0 0;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            min-width: 400px;
            min-height: 300px;
            display: none;
            z-index: 2;
        }

        .window.active {
            display: block;
            z-index: 10;
        }

        .window-titlebar {
            background: var(--taskbar-gradient);
            color: white;
            padding: 4px 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 6px 6px 0 0;
            font-size: 11px;
            font-weight: bold;
            height: 26px;
        }

        .window-title {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .window-title img {
            width: 16px;
            height: 16px;
        }

        .window-controls {
            display: flex;
            gap: 2px;
        }

        .window-button {
            width: 21px;
            height: 21px;
            background: var(--xp-gray);
            border: 1px outset var(--xp-border-light);
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }

        .window-button:hover {
            background: var(--xp-light-gray);
        }

        .window-button:active {
            border: 1px inset var(--xp-border-light);
        }

        .window-button.close:hover {
            background: #ff4444;
            color: white;
        }

        .window-content {
            padding: 15px;
            background: white;
            height: calc(100% - 26px);
            overflow-y: auto;
            font-size: 11px;
            border: 1px inset var(--xp-border-light);
            border-top: none;
        }

        .taskbar {
            height: 40px;
            background: var(--taskbar-gradient);
            border-top: 1px solid var(--xp-light-blue);
            display: flex;
            align-items: center;
            padding: 0 4px;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.2);
            z-index: 100;
        }

        .start-button {
            background: linear-gradient(to bottom, #73D216 0%, #4E9A06 100%);
            border: 1px outset #73D216;
            color: white;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 11px;
            cursor: pointer;
            border-radius: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-right: 8px;
        }

        .start-button img {
            width: 16px;
            height: 16px;
        }

        .start-button:hover {
            background: linear-gradient(to bottom, #8AE234 0%, #73D216 100%);
        }

        .start-button:active {
            border: 1px inset #73D216;
        }

        .taskbar-programs {
            display: flex;
            gap: 2px;
            flex: 1;
        }

        .taskbar-program {
            background: var(--xp-light-blue);
            border: 1px outset var(--xp-light-blue);
            color: white;
            padding: 4px 8px;
            font-size: 11px;
            cursor: pointer;
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .taskbar-program.active {
            background: var(--xp-dark-blue);
            border: 1px inset var(--xp-light-blue);
        }

        .taskbar-program img {
            width: 16px;
            height: 16px;
        }

        .system-tray {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            padding: 0 8px;
            border-left: 1px solid var(--xp-dark-blue);
            height: 100%;
            color: white;
            font-size: 11px;
        }

        .clock {
            text-align: center;
            line-height: 1.2;
        }

        .start-menu {
            position: absolute;
            bottom: 40px;
            left: 0;
            width: 250px;
            background: var(--taskbar-bg);
            border: 2px outset var(--xp-border-light);
            z-index: 99;
            display: none;
            flex-direction: column;
            color: white;
        }
        
        .start-menu.active {
            display: flex;
        }

        .start-menu-header {
            background: var(--taskbar-gradient);
            padding: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 13px;
        }

        .start-menu-header img {
            width: 40px;
            height: 40px;
            border-radius: 3px;
            border: 1px solid var(--xp-light-blue);
        }

        .start-menu-body {
            background: white;
            padding: 5px;
        }

        .start-menu-programs {
            list-style: none;
        }

        .start-menu-programs li {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px;
            cursor: pointer;
            color: black;
            font-size: 11px;
        }

        .start-menu-programs li:hover {
            background: var(--xp-blue);
            color: white;
        }
        
        .start-menu-programs img {
            width: 24px;
            height: 24px;
        }
        
        .notepad-content {
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            line-height: 1.4;
        }

        .explorer-content {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .explorer-toolbar {
            border: 1px inset var(--xp-border-light);
            padding: 4px;
            background: var(--xp-gray);
            font-size: 11px;
        }

        .explorer-list {
            border: 1px inset var(--xp-border-light);
            background: white;
            min-height: 200px;
            padding: 5px;
        }

        .explorer-item {
            padding: 2px 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border-radius: 2px;
        }

        .explorer-item:hover {
            background: #E0E8FF;
        }

        .explorer-item img {
            width: 16px;
            height: 16px;
        }

        .calculator-content {
            width: 250px;
            background: var(--xp-gray);
            padding: 10px;
        }

        .calculator-display {
            background: white;
            border: 1px inset var(--xp-border-light);
            padding: 8px;
            text-align: right;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .calculator-buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(5, 1fr);
            gap: 4px;
        }

        .calc-button {
            background: var(--xp-gray);
            border: 1px outset var(--xp-border-light);
            padding: 8px;
            font-size: 11px;
            cursor: pointer;
            text-align: center;
        }

        .calc-button:active {
            border: 1px inset var(--xp-border-light);
        }
        
        .calc-button.zero { grid-column: span 2; }
        .calc-button.equals { grid-column: span 2; }
        .calc-button.operator, .calc-button.equals { background-color: var(--xp-dark-gray); }

        .media-player-content {
            background: #1a1a1a;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .avatar-display {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 15px;
            border: 3px solid #333;
            object-fit: cover;
        }

        .control-panel-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .control-panel-item {
            border: 1px inset var(--xp-border-light);
            padding: 10px;
            background: var(--xp-light-gray);
        }

        .control-panel-item h3 {
            color: var(--xp-dark-blue);
            margin-bottom: 8px;
            font-size: 12px;
        }

        .skill-tag {
            display: inline-block;
            background: var(--xp-blue);
            color: white;
            padding: 2px 6px;
            margin: 2px;
            border-radius: 2px;
            font-size: 10px;
        }

        .project-item, .experience-item, .education-item {
            border: 1px solid var(--xp-border-dark);
            margin-bottom: 10px;
            padding: 8px;
            background: white;
        }

        .project-item h4, .experience-item h4, .education-item h4 {
            color: var(--xp-dark-blue);
            margin-bottom: 5px;
            font-size: 12px;
        }

        .date-range {
            color: #666;
            font-style: italic;
            font-size: 10px;
        }

        .social-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .social-link {
            background: var(--xp-blue);
            color: white;
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 2px;
            font-size: 10px;
            border: 1px outset var(--xp-blue);
        }

        .social-link:hover {
            background: var(--xp-light-blue);
        }

        #window-about { top: 50px; left: 100px; width: 500px; height: 400px; }
        #window-skills { top: 80px; left: 130px; width: 450px; height: 350px; }
        #window-projects { top: 110px; left: 160px; width: 600px; height: 500px; }
        #window-experience { top: 70px; left: 200px; width: 550px; height: 450px; }
        #window-education { top: 100px; left: 230px; width: 500px; height: 350px; }
        #window-contact { top: 90px; left: 260px; width: 400px; height: 300px; }
        #window-media { top: 120px; left: 180px; width: 350px; height: 300px; }
        #window-calculator { top: 150px; left: 300px; width: 270px; height: 320px; }

        @media (max-width: 768px) {
            .window {
                width: calc(100vw - 20px) !important;
                height: calc(100vh - 80px) !important;
                top: 10px !important;
                left: 10px !important;
            }
            
            .desktop-icons {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px;
            }
            
            .desktop-icon {
                width: 60px;
                height: 60px;
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="desktop" id="desktop">
        <div class="desktop-icons">
            <div class="desktop-icon" data-window="about">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='4' width='24' height='24' fill='%23FFD700' stroke='%23B8860B' stroke-width='2'/%3E%3Ctext x='16' y='20' text-anchor='middle' font-family='Arial' font-size='16' font-weight='bold' fill='%23000'%3Ei%3C/text%3E%3C/svg%3E" alt="">
                <span>About Me</span>
            </div>
            <div class="desktop-icon" data-window="skills">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='2' y='6' width='28' height='20' fill='%234169E1' stroke='%232E4BC6' stroke-width='2'/%3E%3Crect x='4' y='8' width='24' height='16' fill='%23000'/%3E%3Ctext x='16' y='18' text-anchor='middle' font-family='monospace' font-size='8' fill='%2300FF00'%3E&lt;/&gt;%3C/text%3E%3C/svg%3E" alt="">
                <span>My Skills</span>
            </div>
            <div class="desktop-icon" data-window="projects">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='4' width='24' height='18' fill='%23FFF' stroke='%23999' stroke-width='2'/%3E%3Crect x='6' y='6' width='20' height='14' fill='%23E0E0E0'/%3E%3Crect x='4' y='22' width='24' height='6' fill='%23C0C0C0' stroke='%23999' stroke-width='1'/%3E%3Ccircle cx='12' cy='25' r='1' fill='%23666'/%3E%3Ccircle cx='20' cy='25' r='1' fill='%23666'/%3E%3C/svg%3E" alt="">
                <span>Projects</span>
            </div>
            <div class="desktop-icon" data-window="experience">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='6' y='8' width='20' height='16' fill='%238B4513' stroke='%23654321' stroke-width='2'/%3E%3Crect x='8' y='10' width='16' height='12' fill='%23A0522D'/%3E%3Ccircle cx='16' cy='16' r='2' fill='%23FFD700'/%3E%3Crect x='14' y='6' width='4' height='4' fill='%23654321'/%3E%3C/svg%3E" alt="">
                <span>Experience</span>
            </div>
            <div class="desktop-icon" data-window="education">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cpolygon points='16,4 28,12 16,20 4,12' fill='%234169E1' stroke='%232E4BC6' stroke-width='2'/%3E%3Cpolygon points='16,6 26,12 16,18 6,12' fill='%235B7FE8'/%3E%3Crect x='4' y='20' width='24' height='4' fill='%232E4BC6'/%3E%3C/svg%3E" alt="">
                <span>Education</span>
            </div>
            <div class="desktop-icon" data-window="contact">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='8' width='24' height='16' fill='%23FFF' stroke='%23999' stroke-width='2'/%3E%3Cpath d='M4 8 L16 16 L28 8' stroke='%23999' stroke-width='2' fill='none'/%3E%3C/svg%3E" alt="">
                <span>Contact</span>
            </div>
            <div class="desktop-icon" data-window="media">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='4' width='24' height='24' fill='%23000' stroke='%23333' stroke-width='2'/%3E%3Cpolygon points='12,10 12,22 22,16' fill='%2300FF00'/%3E%3C/svg%3E" alt="">
                <span>Media Player</span>
            </div>
            <div class="desktop-icon" data-window="calculator">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='4' width='24' height='24' fill='%23C0C0C0' stroke='%23999' stroke-width='2'/%3E%3Crect x='6' y='6' width='20' height='6' fill='%23000'/%3E%3Ctext x='25' y='10' text-anchor='end' font-family='monospace' font-size='4' fill='%2300FF00'%3E123%3C/text%3E%3C/svg%3E" alt="">
                <span>Calculator</span>
            </div>
        </div>

        <div class="windows-container">
            <div class="window" id="window-about">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect width='16' height='16' fill='%23FFD700'/%3E%3Ctext x='8' y='12' text-anchor='middle' font-size='10' font-weight='bold'%3Ei%3C/text%3E%3C/svg%3E" alt="">
                        About Me - Notepad
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('about')">×</div>
                    </div>
                </div>
                <div class="window-content">
                    <div class="notepad-content">{{ $data['name'] ?? 'Anonymous User' }}
{{ $data['title'] ?? 'Software Developer' }}
📍 {{ $data['location'] ?? 'Unknown Location' }}

Bio: {{ $data['bio'] ?? 'No bio available.' }}

About Me:
{{ $data['about_me'] ?? 'A passionate developer eager to build awesome things.' }}

Email: {{ $data['email'] ?? 'Not provided' }}
Portfolio Requests: {{ $data['api_request_count'] ?? 0 }}
                    </div>
                </div>
            </div>

            <div class="window" id="window-skills">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect width='16' height='16' fill='%234169E1'/%3E%3C/svg%3E" alt="">
                        Control Panel - Skills & Technologies
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('skills')">×</div>
                    </div>
                </div>
                <div class="window-content">
                    <div class="control-panel-content">
                        <div class="control-panel-item">
                            <h3>Technical Skills</h3>
                            <div>
                                @forelse($data['skills'] as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                @empty
                                    <p>No skills listed yet.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="control-panel-item">
                            <h3>System Information</h3>
                            <p><strong>Developer:</strong> {{ $data['name'] ?? 'Unknown' }}</p>
                            <p><strong>Username:</strong> {{ $data['username'] ?? 'user' }}</p>
                            <p><strong>Location:</strong> {{ $data['location'] ?? 'Not specified' }}</p>
                            <p><strong>Status:</strong> Available for opportunities</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="window" id="window-projects">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect width='16' height='12' fill='%23FFF' stroke='%23999'/%3E%3Crect width='16' height='4' y='12' fill='%23C0C0C0'/%3E%3C/svg%3E" alt="">
                        My Projects - Windows Explorer
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('projects')">×</div>
                    </div>
                </div>
                <div class="window-content">
                    <div class="explorer-content">
                        <div class="explorer-toolbar">
                            Projects Folder - {{ count($data['projects'] ?? []) }} items
                        </div>
                        <div class="explorer-list">
                            @forelse($data['projects'] as $project)
                                <div class="project-item">
                                    <h4>{{ $project['title'] ?? $project['name'] ?? 'Untitled Project' }}</h4>
                                    <p>{{ $project['description'] ?? 'No description provided.' }}</p>
                                    @if(!empty($project['url']))
                                        <p><strong>URL:</strong> <a href="{{ $project['url'] }}" target="_blank">{{ $project['url'] }}</a></p>
                                    @endif
                                </div>
                            @empty
                                <div class="explorer-item">
                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect width='16' height='16' fill='%23FFF'/%3E%3Ctext x='8' y='8' text-anchor='middle' font-size='10'%3E?%3C/text%3E%3C/svg%3E" alt="">
                                    <span>No projects found</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="window" id="window-experience">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect width='16' height='12' fill='%238B4513'/%3E%3Crect width='12' height='8' x='2' y='2' fill='%23A0522D'/%3E%3C/svg%3E" alt="">
                        Work Experience - Document Viewer
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('experience')">×</div>
                    </div>
                </div>
                <div class="window-content">
                    @forelse($data['experiences'] as $exp)
                        <div class="experience-item">
                            <h4>{{ $exp['title'] ?? 'Job Title' }} at {{ $exp['company'] ?? 'Company Name' }}</h4>
                            <div class="date-range">
                                {{ $exp['start_date'] ?? 'Start Date' }} - {{ $exp['end_date'] ?? 'Present' }}
                                @if(!empty($exp['location']))
                                    | 📍 {{ $exp['location'] }}
                                @endif
                            </div>
                            @if(!empty($exp['description']))
                                <p>{{ $exp['description'] }}</p>
                            @endif
                        </div>
                        @empty
                            <p>No work experience added yet.</p>
                        @endforelse
                </div>
            </div>

            <div class="window" id="window-education">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpolygon points='8,2 14,6 8,10 2,6' fill='%234169E1'/%3E%3C/svg%3E" alt="">
                        Education - Document Viewer
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('education')">×</div>
                    </div>
                </div>
                <div class="window-content">
                    @forelse($data['education'] as $edu)
                        <div class="education-item">
                            <h4>{{ $edu['degree'] ?? 'Degree' }} at {{ $edu['institution'] ?? 'Institution' }}</h4>
                            <div class="date-range">
                                {{ $edu['start_date'] ?? 'Start Date' }} - {{ $edu['end_date'] ?? 'Graduation Date' }}
                            </div>
                            @if(!empty($edu['description']))
                                <p>{{ $edu['description'] }}</p>
                            @endif
                        </div>
                    @empty
                        <p>No education details available.</p>
                    @endforelse
                </div>
            </div>

            <div class="window" id="window-contact">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect x='2' y='4' width='12' height='8' fill='%23FFF' stroke='%23999'/%3E%3C/svg%3E" alt="">
                        Contact - Outlook Express
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('contact')">×</div>
                    </div>
                </div>
                <div class="window-content">
                    <p><strong>Email:</strong> {{ $data['email'] ?? 'Not provided' }}</p>
                    <p><strong>Phone:</strong> {{ $data['phone'] ?? 'Not provided' }}</p>
                    <div class="social-links">
                        @forelse($data['socials'] as $platform => $link)
                            <a class="social-link" href="{{ $link }}" target="_blank">{{ ucfirst($platform) }}</a>
                        @empty
                            <p>No social links available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="window" id="window-media">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpolygon points='6,4 6,12 12,8' fill='%2300FF00'/%3E%3C/svg%3E" alt="">
                        Media Player
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('media')">×</div>
                    </div>
                </div>
                <div class="window-content media-player-content">
                    <img class="avatar-display" src="{{ $data['avatar_url'] ?? asset('images/default-avatar.jpg') }}" alt="Avatar">
                    <p>Now Playing: {{ $data['now_playing'] ?? 'Nothing playing' }}</p>
                </div>
            </div>

            <div class="window" id="window-calculator">
                <div class="window-titlebar">
                    <div class="window-title">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Crect width='16' height='16' fill='%23C0C0C0'/%3E%3C/svg%3E" alt="">
                        Calculator
                    </div>
                    <div class="window-controls">
                        <div class="window-button minimize">_</div>
                        <div class="window-button maximize">□</div>
                        <div class="window-button close" onclick="closeWindow('calculator')">×</div>
                    </div>
                </div>
                <div class="window-content calculator-content">
                    <div class="calculator-display" id="calc-display">0</div>
                    <div class="calculator-buttons">
                        <div class="calc-button" data-action="clear">C</div>
                        <div class="calc-button operator">/</div>
                        <div class="calc-button operator">*</div>
                        <div class="calc-button operator">-</div>
                        <div class="calc-button number">7</div>
                        <div class="calc-button number">8</div>
                        <div class="calc-button number">9</div>
                        <div class="calc-button operator" style="grid-row: span 2;">+</div>
                        <div class="calc-button number">4</div>
                        <div class="calc-button number">5</div>
                        <div class="calc-button number">6</div>
                        <div class="calc-button number">1</div>
                        <div class="calc-button number">2</div>
                        <div class="calc-button number">3</div>
                        <div class="calc-button equals" style="grid-row: span 2;">=</div>
                        <div class="calc-button number zero" style="grid-column: span 2;">0</div>
                        <div class="calc-button decimal">.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="taskbar">
            <div class="start-button" id="start-button">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23f00' d='M0 0h11v11H0z'/%3E%3Cpath fill='%230f0' d='M13 0h11v11H13z'/%3E%3Cpath fill='%2300f' d='M0 13h11v11H0z'/%3E%3Cpath fill='%23ff0' d='M13 13h11v11H13z'/%3E%3C/svg%3E" alt="Start">
                Start
            </div>
            <div class="taskbar-programs" id="taskbar-programs"></div>
            <div class="system-tray">
                <div class="clock" id="clock">00:00</div>
            </div>
        </div>
        
        <div class="start-menu" id="start-menu">
            <div class="start-menu-header">
                <img src="{{ $data['avatar_url'] ?? asset('images/default-avatar.jpg') }}" alt="User Avatar">
                <span>{{ $data['name'] ?? 'User' }}</span>
            </div>
            <div class="start-menu-body">
                <ul class="start-menu-programs">
                    <li data-window="about"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='4' width='24' height='24' fill='%23FFD700' stroke='%23B8860B' stroke-width='2'/%3E%3Ctext x='16' y='20' text-anchor='middle' font-family='Arial' font-size='16' font-weight='bold' fill='%23000'%3Ei%3C/text%3E%3C/svg%3E" alt=""><span>About Me</span></li>
                    <li data-window="skills"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='2' y='6' width='28' height='20' fill='%234169E1' stroke='%232E4BC6' stroke-width='2'/%3E%3Crect x='4' y='8' width='24' height='16' fill='%23000'/%3E%3Ctext x='16' y='18' text-anchor='middle' font-family='monospace' font-size='8' fill='%2300FF00'%3E&lt;/&gt;%3C/text%3E%3C/svg%3E" alt=""><span>My Skills</span></li>
                    <li data-window="projects"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='4' width='24' height='18' fill='%23FFF' stroke='%23999' stroke-width='2'/%3E%3Crect x='6' y='6' width='20' height='14' fill='%23E0E0E0'/%3E%3Crect x='4' y='22' width='24' height='6' fill='%23C0C0C0' stroke='%23999' stroke-width='1'/%3E%3Ccircle cx='12' cy='25' r='1' fill='%23666'/%3E%3Ccircle cx='20' cy='25' r='1' fill='%23666'/%3E%3C/svg%3E" alt=""><span>Projects</span></li>
                    <li data-window="experience"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='6' y='8' width='20' height='16' fill='%238B4513' stroke='%23654321' stroke-width='2'/%3E%3Crect x='8' y='10' width='16' height='12' fill='%23A0522D'/%3E%3Ccircle cx='16' cy='16' r='2' fill='%23FFD700'/%3E%3Crect x='14' y='6' width='4' height='4' fill='%23654321'/%3E%3C/svg%3E" alt=""><span>Experience</span></li>
                    <li data-window="education"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cpolygon points='16,4 28,12 16,20 4,12' fill='%234169E1' stroke='%232E4BC6' stroke-width='2'/%3E%3Cpolygon points='16,6 26,12 16,18 6,12' fill='%235B7FE8'/%3E%3Crect x='4' y='20' width='24' height='4' fill='%232E4BC6'/%3E%3C/svg%3E" alt=""><span>Education</span></li>
                    <li data-window="contact"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect x='4' y='8' width='24' height='16' fill='%23FFF' stroke='%23999' stroke-width='2'/%3E%3Cpath d='M4 8 L16 16 L28 8' stroke='%23999' stroke-width='2' fill='none'/%3E%3C/svg%3E" alt=""><span>Contact</span></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const desktop = document.getElementById('desktop');
        const icons = document.querySelectorAll('.desktop-icon');
        const windows = document.querySelectorAll('.window');
        const taskbarPrograms = document.getElementById('taskbar-programs');
        const clock = document.getElementById('clock');
        const startButton = document.getElementById('start-button');
        const startMenu = document.getElementById('start-menu');

        function openWindow(id) {
            const win = document.getElementById('window-' + id);
            if (!win) return;

            windows.forEach(w => w.classList.remove('active'));
            win.classList.add('active');

            let btn = document.querySelector('.taskbar-program[data-window="' + id + '"]');
            if (!btn) {
                btn = document.createElement('div');
                btn.className = 'taskbar-program';
                btn.dataset.window = id;
                const iconSrc = document.querySelector(`.desktop-icon[data-window="${id}"] img`).src;
                btn.innerHTML = `<img src="${iconSrc}" alt=""><span>${id.charAt(0).toUpperCase() + id.slice(1)}</span>`;
                btn.onclick = () => openWindow(id);
                taskbarPrograms.appendChild(btn);
            }
            document.querySelectorAll('.taskbar-program').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        function closeWindow(id) {
            const win = document.getElementById('window-' + id);
            if (win) win.classList.remove('active');
            const btn = document.querySelector('.taskbar-program[data-window="' + id + '"]');
            if (btn) btn.remove();
        }

        icons.forEach(icon => {
            icon.addEventListener('dblclick', () => {
                openWindow(icon.dataset.window);
            });
        });

        function updateClock() {
            const now = new Date();
            clock.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        startButton.addEventListener('click', (event) => {
            event.stopPropagation();
            startMenu.classList.toggle('active');
        });

        desktop.addEventListener('click', () => {
            if (startMenu.classList.contains('active')) {
                startMenu.classList.remove('active');
            }
        });

        document.querySelectorAll('.start-menu-programs li').forEach(item => {
            item.addEventListener('click', () => {
                openWindow(item.dataset.window);
                startMenu.classList.remove('active');
            });
        });
        
        const calculator = document.getElementById('window-calculator');
        const calcDisplay = document.getElementById('calc-display');
        const calcButtons = calculator.querySelector('.calculator-buttons');

        const calculatorState = {
            displayValue: '0',
            firstOperand: null,
            waitingForSecondOperand: false,
            operator: null,
        };

        function updateDisplay() {
            calcDisplay.textContent = calculatorState.displayValue;
        }
        updateDisplay();

        function inputDigit(digit) {
            const { displayValue, waitingForSecondOperand } = calculatorState;
            if (waitingForSecondOperand === true) {
                calculatorState.displayValue = digit;
                calculatorState.waitingForSecondOperand = false;
            } else {
                calculatorState.displayValue = displayValue === '0' ? digit : displayValue + digit;
            }
        }

        function inputDecimal(dot) {
            if (calculatorState.waitingForSecondOperand) return;
            if (!calculatorState.displayValue.includes(dot)) {
                calculatorState.displayValue += dot;
            }
        }

        function handleOperator(nextOperator) {
            const { firstOperand, displayValue, operator } = calculatorState;
            const inputValue = parseFloat(displayValue);

            if (operator && calculatorState.waitingForSecondOperand) {
                calculatorState.operator = nextOperator;
                return;
            }

            if (firstOperand == null && !isNaN(inputValue)) {
                calculatorState.firstOperand = inputValue;
            } else if (operator) {
                const result = performCalculation[operator](firstOperand, inputValue);
                calculatorState.displayValue = String(result);
                calculatorState.firstOperand = result;
            }
            
            calculatorState.waitingForSecondOperand = true;
            calculatorState.operator = nextOperator;
        }

        const performCalculation = {
            '/': (firstOperand, secondOperand) => firstOperand / secondOperand,
            '*': (firstOperand, secondOperand) => firstOperand * secondOperand,
            '+': (firstOperand, secondOperand) => firstOperand + secondOperand,
            '-': (firstOperand, secondOperand) => firstOperand - secondOperand,
            '=': (firstOperand, secondOperand) => secondOperand
        };

        function resetCalculator() {
            calculatorState.displayValue = '0';
            calculatorState.firstOperand = null;
            calculatorState.waitingForSecondOperand = false;
            calculatorState.operator = null;
        }

        calcButtons.addEventListener('click', (event) => {
            const { target } = event;
            if (!target.matches('.calc-button')) return;

            if (target.classList.contains('operator')) {
                handleOperator(target.textContent);
            } else if (target.classList.contains('decimal')) {
                inputDecimal(target.textContent);
            } else if (target.classList.contains('number')) {
                inputDigit(target.textContent);
            } else if (target.dataset.action === 'clear') {
                resetCalculator();
            } else if (target.classList.contains('equals')) {
                handleOperator(target.textContent);
            }
            
            updateDisplay();
        });
    </script>
</body>
</html>