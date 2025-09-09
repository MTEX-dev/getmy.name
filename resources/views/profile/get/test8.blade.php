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
    <style>
        :root {
            --dark-bg: #060a07;
            --salmon: #fa8072;
            --cream: #faebd7;
            --light-bg: #ffffff;
            --light-text: #333333;
            --dark-text: #faebd7;
            --card-bg-light: rgba(250, 235, 215, 0.1);
            --card-bg-dark: rgba(250, 128, 114, 0.1);
            --border-light: rgba(51, 51, 51, 0.2);
            --border-dark: rgba(250, 235, 215, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        body.light-mode {
            background: linear-gradient(135deg, var(--light-bg) 0%, var(--cream) 100%);
            color: var(--light-text);
        }

        body.dark-mode {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #0a1108 100%);
            color: var(--dark-text);
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--salmon);
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(250, 128, 114, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(250, 128, 114, 0.4);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .hero {
            text-align: center;
            padding: 80px 0 60px;
            position: relative;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--salmon);
            margin: 0 auto 30px;
            display: block;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(250, 128, 114, 0.3);
            transition: transform 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.05);
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            background: linear-gradient(45deg, var(--salmon), #ff6b47);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero .title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .hero .bio-text {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }

        .location {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            opacity: 0.7;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .social-links a {
            padding: 12px 20px;
            background: var(--salmon);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .social-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(250, 128, 114, 0.3);
        }

        .section {
            margin: 60px 0;
        }

        .section h2 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 40px;
            color: var(--salmon);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .about-me {
            max-width: 800px;
            margin: 0 auto 40px;
            font-size: 1.1rem;
            line-height: 1.8;
            text-align: center;
            opacity: 0.9;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 40px 0;
        }

        .skill-tag {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .light-mode .skill-tag {
            background: var(--card-bg-light);
            border: 1px solid var(--border-light);
        }

        .dark-mode .skill-tag {
            background: var(--card-bg-dark);
            border: 1px solid var(--border-dark);
        }

        .skill-tag:hover {
            transform: translateY(-2px);
            background: var(--salmon);
            color: white;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .card {
            border-radius: 15px;
            padding: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .light-mode .card {
            background: var(--card-bg-light);
            border: 1px solid var(--border-light);
            backdrop-filter: blur(10px);
        }

        .dark-mode .card {
            background: var(--card-bg-dark);
            border: 1px solid var(--border-dark);
            backdrop-filter: blur(10px);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, var(--salmon), #ff6b47);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(250, 128, 114, 0.2);
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--salmon);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card p {
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .project-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .project-image:hover {
            transform: scale(1.02);
        }

        .project-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            padding: 8px 16px;
            background: var(--salmon);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .project-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(250, 128, 114, 0.3);
        }

        .date {
            font-size: 0.9rem;
            opacity: 0.7;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .company {
            font-weight: 600;
            color: var(--salmon);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .education-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        footer {
            text-align: center;
            padding: 40px 0;
            margin-top: 80px;
            border-top: 1px solid var(--border-light);
            opacity: 0.7;
        }

        .dark-mode footer {
            border-top: 1px solid var(--border-dark);
        }

        footer a {
            color: var(--salmon);
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero .title {
                font-size: 1.2rem;
            }

            .section h2 {
                font-size: 2rem;
            }

            .social-links {
                flex-wrap: wrap;
            }

            .grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .theme-toggle {
                top: 10px;
                right: 10px;
                padding: 10px 15px;
                font-size: 12px;
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
                    <p class="about-me">{{ $data['about_me'] }}</p>
                </div>
            @endif

            @if(!empty($data['skills']))
                <div class="section">
                    <h2>
                        <i class="bi bi-tools"></i>
                        Skills
                    </h2>
                    <div class="skills">
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
        <p>
            &copy; {{ date('Y') }} {{ $data['name'] ?? 'Profile' }}. All Rights Reserved.
        </p>
        <p>
            Powered by <a href="https://getmy.name" target="_blank">getmy.name</a> from <a href="https://mtex.dev" target="_blank">mtex.dev</a>
            @if(isset($data['username']))
                <span class="mx-1">|</span> User: {{ $data['username'] }}
            @endif
            @if(isset($data['api_requests']))
                <span class="mx-1">|</span> API Requests: {{ $data['api_requests'] }}
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
        })();
    </script>
</body>
</html>