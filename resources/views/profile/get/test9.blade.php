<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $title = ($data['name'] ?? 'Profile') . ' - ' . ($data['title'] ?? 'Portfolio');
        $description = $data['bio'] ?? 'Explore my professional profile, skills, projects, and experience.';
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
    @if(isset($data['socials']['twitter']))
        <meta name="twitter:creator" content="{{ '@' . ltrim($data['socials']['twitter'], '@') }}">
    @endif

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0C0F13;
            --light-bg: #FFFFFF;
            --primary-color: #FA8072;
            --secondary-color: #4A4A68;
            --accent-color: #FFC0CB;
            --text-light: #333333;
            --text-dark: #E0E0E0;
            --card-light: #FFFFFF;
            --card-dark: #1F222A;
            --border-light: #E0E0E0;
            --border-dark: #33363F;
            --shadow-light: rgba(0, 0, 0, 0.08);
            --shadow-dark: rgba(0, 0, 0, 0.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            transition: all 0.4s ease-in-out;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body.light-mode {
            background-color: var(--light-bg);
            color: var(--text-light);
        }

        body.dark-mode {
            background-color: var(--dark-bg);
            color: var(--text-dark);
        }

        .theme-toggle {
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 1000;
            background-color: var(--primary-color);
            border: none;
            border-radius: 50px;
            padding: 12px 22px;
            color: white;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(250, 128, 114, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        .theme-toggle:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(250, 128, 114, 0.5);
        }
        .theme-toggle i {
            font-size: 1.1em;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .hero {
            text-align: center;
            padding: 100px 0 80px;
            background: radial-gradient(circle at top left, rgba(250,128,114,0.05) 0%, transparent 40%),
                        radial-gradient(circle at bottom right, rgba(255,192,203,0.05) 0%, transparent 40%);
            border-radius: 15px;
            margin-bottom: 60px;
        }

        .avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 5px solid var(--primary-color);
            padding: 3px;
            margin: 0 auto 35px;
            display: block;
            object-fit: cover;
            box-shadow: 0 12px 30px var(--shadow-dark);
            transition: transform 0.4s ease;
        }
        .light-mode .avatar {
             box-shadow: 0 12px 30px var(--shadow-light);
        }

        .avatar:hover {
            transform: scale(1.06) rotate(2deg);
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 12px;
            font-weight: 700;
            letter-spacing: -0.5px;
            background: linear-gradient(90deg, var(--primary-color), #FF6F61);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero .title {
            font-size: 1.6rem;
            margin-bottom: 25px;
            color: var(--secondary-color);
            font-weight: 500;
        }
        .dark-mode .hero .title {
            color: var(--accent-color);
        }

        .hero .bio-text {
            font-size: 1.15rem;
            max-width: 700px;
            margin: 0 auto 35px;
            opacity: 0.85;
            line-height: 1.7;
        }

        .location {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            opacity: 0.7;
            margin-bottom: 35px;
            font-size: 1.1rem;
            font-weight: 400;
        }
        .location i {
            font-size: 1.2em;
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .social-links a {
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.4px;
            box-shadow: 0 5px 15px rgba(250, 128, 114, 0.3);
        }

        .social-links a:hover {
            transform: translateY(-4px) scale(1.03);
            background-color: #FF6F61;
            box-shadow: 0 8px 20px rgba(250, 128, 114, 0.45);
        }
        .social-links a i {
            font-size: 1.1em;
        }

        .section {
            margin: 80px 0;
        }

        .section h2 {
            font-size: 2.8rem;
            text-align: center;
            margin-bottom: 50px;
            color: var(--primary-color);
            font-weight: 700;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
        }
        .section h2 i {
            font-size: 1.1em;
        }

        .about-me-content {
            max-width: 900px;
            margin: 0 auto 50px;
            font-size: 1.15rem;
            line-height: 1.9;
            text-align: justify;
            opacity: 0.9;
            background-color: var(--card-light);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px var(--shadow-light);
            transition: all 0.3s ease;
        }
        .dark-mode .about-me-content {
            background-color: var(--card-dark);
            box-shadow: 0 6px 20px var(--shadow-dark);
        }
        .about-me-content:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px var(--shadow-light);
        }
        .dark-mode .about-me-content:hover {
            box-shadow: 0 10px 25px var(--shadow-dark);
        }


        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 18px;
            margin-top: 50px;
        }

        .skill-tag {
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 1.05rem;
            border: 1px solid transparent;
        }

        .light-mode .skill-tag {
            background-color: var(--accent-color);
            color: var(--text-light);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .light-mode .skill-tag:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 12px rgba(250, 128, 114, 0.3);
        }

        .dark-mode .skill-tag {
            background-color: rgba(var(--primary-color-rgb), 0.2);
            border-color: rgba(var(--primary-color-rgb), 0.4);
            color: var(--text-dark);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .dark-mode .skill-tag:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 12px rgba(250, 128, 114, 0.3);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 35px;
            margin-top: 50px;
        }

        .card {
            border-radius: 15px;
            padding: 35px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-light);
            box-shadow: 0 8px 25px var(--shadow-light);
        }
        .light-mode .card {
            background-color: var(--card-light);
        }
        .dark-mode .card {
            background-color: var(--card-dark);
            border: 1px solid var(--border-dark);
            box-shadow: 0 8px 25px var(--shadow-dark);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), #FF6F61);
            border-radius: 15px 15px 0 0;
        }

        .card:hover {
            transform: translateY(-7px) scale(1.01);
            box-shadow: 0 15px 40px var(--shadow-light);
        }
        .dark-mode .card:hover {
             box-shadow: 0 15px 40px var(--shadow-dark);
        }

        .card h3 {
            font-size: 1.7rem;
            margin-bottom: 18px;
            color: var(--primary-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .card h3 i {
            font-size: 1.1em;
        }

        .card p {
            margin-bottom: 12px;
            opacity: 0.85;
            line-height: 1.7;
        }

        .project-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .project-image:hover {
            transform: scale(1.02);
        }

        .project-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .project-link:hover {
            transform: translateY(-2px);
            background-color: #FF6F61;
            box-shadow: 0 4px 10px rgba(250, 128, 114, 0.4);
        }

        .date, .company, .education-info {
            font-size: 0.95rem;
            opacity: 0.8;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 400;
        }
        .company {
            font-weight: 500;
            color: var(--secondary-color);
        }
        .dark-mode .company {
            color: var(--accent-color);
        }
        .date i, .company i, .education-info i {
            font-size: 1.1em;
            color: var(--primary-color);
        }
        .education-info strong {
            color: var(--primary-color);
            font-weight: 600;
        }


        footer {
            text-align: center;
            padding: 50px 0;
            margin-top: 100px;
            border-top: 1px solid var(--border-light);
            opacity: 0.7;
            font-size: 0.95rem;
        }
        .dark-mode footer {
            border-top: 1px solid var(--border-dark);
        }

        footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #FF6F61;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 80px 0 60px;
            }
            .hero h1 {
                font-size: 2.8rem;
            }
            .hero .title {
                font-size: 1.4rem;
            }
            .hero .bio-text, .about-me-content {
                font-size: 1rem;
                padding: 30px;
            }
            .section h2 {
                font-size: 2.2rem;
                margin-bottom: 40px;
            }
            .social-links {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            .social-links a {
                width: 80%;
                justify-content: center;
            }
            .grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            .card {
                padding: 25px;
            }
            .card h3 {
                font-size: 1.5rem;
            }
            .project-image {
                height: 180px;
            }
            .theme-toggle {
                top: 15px;
                right: 15px;
                padding: 10px 18px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body class="dark-mode">
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="bi bi-moon-stars"></i>
        <span>Dark</span>
    </button>

    <div class="container">
        <div id="portfolio">
            <div class="hero">
                <img src="{{ $data['avatar_url'] ?? '' }}" alt="{{ $data['name'] ?? 'Avatar' }}" class="avatar">
                <h1>{{ $data['name'] ?? 'Unnamed User' }}</h1>
                <div class="title">{{ $data['title'] ?? '' }}</div>
                <div class="bio-text">{{ $data['bio'] ?? '' }}</div>
                @if(!empty($data['location']))
                    <div class="location">
                        <i class="bi bi-geo-alt"></i>
                        {{ $data['location'] }}
                    </div>
                @endif

                <div class="social-links">
                    @if(!empty($data['socials']['github']))
                        <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank"><i class="bi bi-github"></i>GitHub</a>
                    @endif
                    @if(!empty($data['socials']['linkedin']))
                        <a href="https://linkedin.com/in/{{ $data['socials']['linkedin'] }}" target="_blank"><i class="bi bi-linkedin"></i>LinkedIn</a>
                    @endif
                    @if(!empty($data['socials']['twitter']))
                        <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank"><i class="bi bi-twitter"></i>Twitter</a>
                    @endif
                    @if(!empty($data['socials']['personal_website']))
                        <a href="{{ $data['socials']['personal_website'] }}" target="_blank"><i class="bi bi-globe"></i>Website</a>
                    @endif
                    @if(!empty($data['email']))
                        <a href="mailto:{{ $data['email'] }}"><i class="bi bi-envelope"></i>Contact</a>
                    @endif
                </div>
            </div>

            @if(!empty($data['about_me']))
                <div class="section">
                    <h2>
                        <i class="bi bi-person-fill"></i>
                        About Me
                    </h2>
                    <div class="about-me-content">
                        {!! nl2br(e($data['about_me'] ?? '')) !!}
                    </div>
                </div>
            @endif

            @if(!empty($data['skills']))
                <div class="section">
                    <h2>
                        <i class="bi bi-tools"></i>
                        Skills
                    </h2>
                    <div class="skills-grid">
                        @foreach($data['skills'] as $skill)
                            <span class="skill-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($data['projects']))
                <div class="section">
                    <h2>
                        <i class="bi bi-code-square"></i>
                        Projects
                    </h2>
                    <div class="grid">
                        @foreach($data['projects'] as $project)
                            <div class="card">
                                @if(!empty($project['image_path']))
                                    <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project image' }}" class="project-image">
                                @endif
                                <h3>
                                    <i class="bi bi-folder"></i>
                                    {{ $project['title'] ?? 'Untitled Project' }}
                                </h3>
                                <p>{{ $project['description'] ?? '' }}</p>
                                @if(!empty($project['url']))
                                    <a href="{{ $project['url'] }}" target="_blank" class="project-link"><i class="bi bi-box-arrow-up-right"></i>View Project</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($data['experiences']))
                <div class="section">
                    <h2>
                        <i class="bi bi-briefcase"></i>
                        Experience
                    </h2>
                    <div class="grid">
                        @foreach($data['experiences'] as $exp)
                            <div class="card">
                                <h3>
                                    <i class="bi bi-person-badge"></i>
                                    {{ $exp['title'] ?? 'Untitled Position' }}
                                </h3>
                                <div class="company">
                                    <i class="bi bi-building"></i>
                                    {{ $exp['company'] ?? '' }}
                                </div>
                                <div class="date">
                                    <i class="bi bi-calendar-range"></i>
                                    {{ \Carbon\Carbon::parse($exp['start_date'])->format('F Y') }} - @if(!empty($exp['end_date'])) {{ \Carbon\Carbon::parse($exp['end_date'])->format('F Y') }} @else Present @endif
                                </div>
                                @if(!empty($exp['location']))
                                    <p><i class="bi bi-geo-alt"></i> {{ $exp['location'] }}</p>
                                @endif
                                <p>{{ $exp['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($data['education']))
                <div class="section">
                    <h2>
                        <i class="bi bi-mortarboard"></i>
                        Education
                    </h2>
                    <div class="grid">
                        @foreach($data['education'] as $edu)
                            <div class="card">
                                <h3>
                                    <i class="bi bi-award"></i>
                                    {{ $edu['degree'] ?? 'Untitled Degree' }}
                                </h3>
                                <div class="company">
                                    <i class="bi bi-bank"></i>
                                    {{ $edu['school'] ?? '' }}
                                </div>
                                <div class="date">
                                    <i class="bi bi-calendar-range"></i>
                                    {{ \Carbon\Carbon::parse($edu['start_date'])->format('F Y') }} - {{ \Carbon\Carbon::parse($edu['end_date'])->format('F Y') }}
                                </div>
                                <div class="education-info">
                                    <i class="bi bi-book"></i>
                                    <strong>Field:</strong> {{ $edu['field_of_study'] ?? '' }}
                                </div>
                                @if(!empty($edu['description']))
                                    <p>{{ $edu['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <footer>
        <p class="mb-1">
            &copy; {{ date('Y') }} {{ $data['name'] ?? 'Profile' }}. All Rights Reserved.
        </p>
        <p>
            Powered by <a href="https://getmy.name" target="_blank">getmy.name</a> from <a href="https://mtex.dev" target="_blank">mtex.dev</a>
            @if(isset($data['username']))
                <span class="separator">|</span> User: {{ $data['username'] }}
            @endif
            @if(isset($data['api_requests']))
                <span class="separator">|</span> API Requests: {{ $data['api_requests'] }}
            @endif
        </p>
    </footer>

    <script>
        let currentTheme = localStorage.getItem('theme') || 'dark';

        function toggleTheme() {
            const body = document.body;
            const button = document.querySelector('.theme-toggle');

            if (currentTheme === 'dark') {
                body.className = 'light-mode';
                button.innerHTML = '<i class="bi bi-sun"></i><span>Light</span>';
                currentTheme = 'light';
            } else {
                body.className = 'dark-mode';
                button.innerHTML = '<i class="bi bi-moon-stars"></i><span>Dark</span>';
                currentTheme = 'dark';
            }

            localStorage.setItem('theme', currentTheme);
        }

        (function() {
            const body = document.body;
            const button = document.querySelector('.theme-toggle');

            if (currentTheme === 'light') {
                body.className = 'light-mode';
                button.innerHTML = '<i class="bi bi-sun"></i><span>Light</span>';
            } else {
                body.className = 'dark-mode';
                button.innerHTML = '<i class="bi bi-moon-stars"></i><span>Dark</span>';
            }

            const r = document.querySelector(':root');
            const primaryColor = getComputedStyle(r).getPropertyValue('--primary-color');
            const match = primaryColor.match(/\d+/g);
            if (match && match.length >= 3) {
                r.style.setProperty('--primary-color-rgb', `${match[0]},${match[1]},${match[2]}`);
            }
        })();
    </script>
</body>
</html>