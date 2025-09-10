<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }}'s Desktop</title>
    <style>
        @font-face {
            font-family: 'Tahoma';
            src: url('https://db.onlinewebfonts.com/t/3f681a53a14b9637b99c382215471418.eot');
            src: url('https://db.onlinewebfonts.com/t/3f681a53a14b9637b99c382215471418.eot?#iefix') format('embedded-opentype'),
                 url('https://db.onlinewebfonts.com/t/3f681a53a14b9637b99c382215471418.woff2') format('woff2'),
                 url('https://db.onlinewebfonts.com/t/3f681a53a14b9637b99c382215471418.woff') format('woff'),
                 url('https://db.onlinewebfonts.com/t/3f681a53a14b9637b99c382215471418.ttf') format('truetype'),
                 url('https://db.onlinewebfonts.com/t/3f681a53a14b9637b99c382215471418.svg#Tahoma') format('svg');
        }

        :root {
            --xp-blue: #0058e1;
            --xp-blue-gradient-start: #083ed7;
            --xp-blue-gradient-end: #5993ff;
            --xp-grey: #ece9d8;
            --xp-border-shadow: #808080;
            --xp-border-highlight: #ffffff;
            --xp-green-start: #78cd4a;
            --xp-green-end: #3ca624;
        }
        
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: 'Tahoma', sans-serif;
            font-size: 11px;
            user-select: none;
        }

        .xp-desktop {
            background: url('https://i.imgur.com/H6bZfQ3.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            width: 100%;
            position: relative;
        }

        .desktop-icon {
            position: absolute;
            width: 80px;
            text-align: center;
            padding: 10px 0;
            cursor: pointer;
        }

        .desktop-icon:hover {
            background-color: rgba(0, 88, 225, 0.2);
            border: 1px solid rgba(0, 88, 225, 0.4);
        }

        .desktop-icon img {
            width: 48px;
            height: 48px;
        }

        .desktop-icon span {
            color: white;
            text-shadow: 1px 1px 2px black;
            display: block;
            margin-top: 5px;
        }
        
        .xp-window {
            display: none;
            position: absolute;
            border: 1px solid var(--xp-blue);
            box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            background-color: var(--xp-grey);
            min-width: 350px;
            min-height: 200px;
        }

        .xp-window .title-bar {
            background: linear-gradient(to bottom, var(--xp-blue-gradient-start), var(--xp-blue-gradient-end));
            padding: 3px 5px;
            color: white;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
        }

        .xp-window .title-bar-controls button {
            background-color: #d64e39;
            border: 1px solid var(--xp-border-shadow);
            border-top-color: var(--xp-border-highlight);
            border-left-color: var(--xp-border-highlight);
            color: white;
            font-weight: bold;
            font-family: 'Courier New', Courier, monospace;
            width: 20px;
            height: 20px;
            cursor: pointer;
            line-height: 14px;
        }
        
        .xp-window .window-body {
            padding: 10px;
            height: calc(100% - 28px);
            overflow-y: auto;
        }

        .xp-taskbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 30px;
            background: linear-gradient(to bottom, #2467ef, #245be3 9%, #1e51d9 18%, #2055da 34%, #245fe8 55%, #246eef 71%, #2467ef 82%, #245ce2 91%, #2458de 100%);
            border-top: 1px solid #4d8ffd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
        }

        .start-button {
            background: linear-gradient(to bottom, var(--xp-green-start), var(--xp-green-end));
            color: white;
            font-weight: bold;
            font-style: italic;
            border: 2px outset #53a837;
            border-radius: 10px 10px 0 0 / 15px 15px 0 0;
            padding: 2px 20px 2px 15px;
            margin-left: 3px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 16px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            cursor: pointer;
        }

        .taskbar-clock {
            background-color: #2781ef;
            border: 1px inset #2d6bce;
            padding: 3px 10px;
            margin-right: 5px;
            color: white;
        }

        .program-content {
            white-space: pre-wrap;
            font-family: 'Lucida Console', Monaco, monospace;
            background-color: white;
            border: 1px inset #808080;
            padding: 5px;
            height: 95%;
            overflow-y: scroll;
        }
        
        .profile-content {
            display: flex;
        }
        .profile-content img {
            width: 64px;
            height: 64px;
            margin-right: 15px;
            border: 1px outset grey;
        }
        
        .list-item {
            padding: 4px;
            border-bottom: 1px dotted #ccc;
        }
        .list-item:last-child {
            border-bottom: none;
        }
        .list-item strong {
            color: var(--xp-blue);
        }

        .socials-list a {
            display: inline-block;
            margin: 5px;
            text-decoration: none;
            color: #0000EE;
        }
        .socials-list a:visited {
            color: #551A8B;
        }
    </style>
</head>
<body>
    <div class="xp-desktop">
        
        <div class="desktop-icon" style="top: 20px; left: 20px;" data-opens="profile-window">
            <img src="https://i.imgur.com/k2gL31B.png" alt="My Computer Icon">
            <span>My Profile</span>
        </div>

        <div class="desktop-icon" style="top: 120px; left: 20px;" data-opens="about-me-window">
            <img src="https://i.imgur.com/M60S5aR.png" alt="Notepad Icon">
            <span>about_me.txt</span>
        </div>
        
        <div class="desktop-icon" style="top: 220px; left: 20px;" data-opens="skills-window">
            <img src="https://i.imgur.com/71jZ1u7.png" alt="Control Panel Icon">
            <span>Skills Catalog</span>
        </div>

        <div class="desktop-icon" style="top: 20px; left: 120px;" data-opens="projects-window">
            <img src="https://i.imgur.com/bwmYj7e.png" alt="Folder Icon">
            <span>Projects</span>
        </div>

        <div class="desktop-icon" style="top: 120px; left: 120px;" data-opens="experience-window">
            <img src="https://i.imgur.com/6lY5aC8.png" alt="Briefcase Icon">
            <span>Career History</span>
        </div>
        
        <div class="desktop-icon" style="top: 220px; left: 120px;" data-opens="education-window">
            <img src="https://i.imgur.com/O618BwL.png" alt="Education Icon">
            <span>Education</span>
        </div>

        <div class="desktop-icon" style="top: 320px; left: 20px;" data-opens="socials-window">
            <img src="https://i.imgur.com/vH9jZkW.png" alt="Internet Explorer Icon">
            <span>Internet</span>
        </div>


        <div class="xp-window" id="profile-window" style="top: 50px; left: 150px; width: 450px;">
            <div class="title-bar">
                <span>Profile Properties</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body profile-content">
                <img src="{{ $data['avatar_url'] }}" alt="Avatar">
                <div>
                    <h3>{{ $data['name'] }} ({{ $data['username'] }})</h3>
                    <p><strong>Title:</strong> {{ $data['title'] }}</p>
                    <p><strong>Location:</strong> {{ $data['location'] }}</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
                    <hr>
                    <p><i>{{ $data['bio'] }}</i></p>
                </div>
            </div>
        </div>
        
        <div class="xp-window" id="about-me-window" style="top: 100px; left: 200px; width: 500px; height: 300px;">
            <div class="title-bar">
                <span>about_me.txt - Notepad</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body">
                <div class="program-content">{{ $data['about_me'] }}</div>
            </div>
        </div>

        <div class="xp-window" id="skills-window" style="top: 150px; left: 250px; width: 380px; height: 250px;">
            <div class="title-bar">
                <span>Skills Catalog</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body">
                 @foreach($data['skills'] as $skill)
                    <div class="list-item">› {{ $skill }}</div>
                @endforeach
            </div>
        </div>

        <div class="xp-window" id="projects-window" style="top: 80px; left: 300px; width: 500px; height: 350px;">
            <div class="title-bar">
                <span>C:\Documents\Projects</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body">
                @forelse($data['projects'] as $project)
                    <div class="list-item">
                        <strong>{{ $project['name'] }}</strong>
                        <p>{{ $project['description'] }}</p>
                        <a href="{{ $project['url'] }}" target="_blank">Visit Project</a>
                    </div>
                @empty
                    <p>No projects to display.</p>
                @endforelse
            </div>
        </div>

        <div class="xp-window" id="experience-window" style="top: 120px; left: 350px; width: 550px; height: 400px;">
            <div class="title-bar">
                <span>Career History</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body">
                @foreach($data['experiences'] as $exp)
                    <div class="list-item">
                        <strong>{{ $exp['title'] }}</strong> at <strong>{{ $exp['company'] }}</strong>
                        <p>
                            <em>
                                {{ \Carbon\Carbon::parse($exp['start_date'])->format('M Y') }}
                                - 
                                {{ $exp['end_date'] ? \Carbon\Carbon::parse($exp['end_date'])->format('M Y') : 'Present' }}
                            </em>
                            @if($exp['location']) | {{ $exp['location'] }} @endif
                        </p>
                        @if($exp['description']) <p style="margin-top: 5px;">{{ $exp['description'] }}</p> @endif
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="xp-window" id="education-window" style="top: 180px; left: 280px; width: 500px; height: 300px;">
            <div class="title-bar">
                <span>Education</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body">
                @foreach($data['education'] as $edu)
                    <div class="list-item">
                        <strong>{{ $edu['school'] }}</strong>
                        <p>{{ $edu['degree'] }} - {{ $edu['field_of_study'] }}</p>
                        <p>
                            <em>
                                {{ \Carbon\Carbon::parse($edu['start_date'])->format('Y') }} - {{ \Carbon\Carbon::parse($edu['end_date'])->format('Y') }}
                            </em>
                        </p>
                        @if($edu['description'])<p>{{ $edu['description'] }}</p>@endif
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="xp-window" id="socials-window" style="top: 200px; left: 400px; width: 400px; height: 250px;">
            <div class="title-bar">
                <span>Internet Explorer</span>
                <div class="title-bar-controls">
                    <button class="close-btn">X</button>
                </div>
            </div>
            <div class="window-body socials-list">
                @if($data['socials']['github'])
                    <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank">GitHub</a>
                @endif
                @if($data['socials']['twitter'])
                    <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank">Twitter</a>
                @endif
                @if($data['socials']['linkedin'])
                    <a href="https://linkedin.com/in/{{ $data['socials']['linkedin'] }}" target="_blank">LinkedIn</a>
                @endif
                 @if($data['socials']['personal_website'])
                    <a href="{{ $data['socials']['personal_website'] }}" target="_blank">Personal Website</a>
                @endif
            </div>
        </div>

        <div class="xp-taskbar">
            <div class="start-button">start</div>
            <div class="taskbar-clock" id="clock">9:00 AM</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const desktop = document.querySelector('.xp-desktop');

            document.querySelectorAll('.desktop-icon').forEach(icon => {
                icon.addEventListener('dblclick', () => {
                    const windowId = icon.getAttribute('data-opens');
                    const windowElement = document.getElementById(windowId);
                    if (windowElement) {
                        windowElement.style.display = 'block';
                    }
                });
            });

            document.querySelectorAll('.close-btn').forEach(button => {
                button.addEventListener('click', () => {
                    button.closest('.xp-window').style.display = 'none';
                });
            });
            
            let activeWindow = null;
            let initialX, initialY, initialWindowX, initialWindowY;

            document.querySelectorAll('.xp-window').forEach(win => {
                const titleBar = win.querySelector('.title-bar');

                titleBar.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    activeWindow = win;
                    initialX = e.clientX;
                    initialY = e.clientY;
                    initialWindowX = win.offsetLeft;
                    initialWindowY = win.offsetTop;
                });
            });

            desktop.addEventListener('mousemove', (e) => {
                if (activeWindow) {
                    e.preventDefault();
                    const dx = e.clientX - initialX;
                    const dy = e.clientY - initialY;
                    activeWindow.style.left = `${initialWindowX + dx}px`;
                    activeWindow.style.top = `${initialWindowY + dy}px`;
                }
            });

            desktop.addEventListener('mouseup', () => {
                activeWindow = null;
            });

            function updateClock() {
                const clockElement = document.getElementById('clock');
                const now = new Date();
                let hours = now.getHours();
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                clockElement.textContent = `${hours}:${minutes} ${ampm}`;
            }

            setInterval(updateClock, 1000);
            updateClock();
        });
    </script>

</body>
</html>