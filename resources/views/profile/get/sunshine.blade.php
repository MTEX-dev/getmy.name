<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] ?? 'Profile' }} - Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #fef7f0;
            color: #2d2d2d;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            padding: 4rem 2rem;
            background: #fff5e6;
            border-radius: 30px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-pattern;
            opacity: 0.03;
            pointer-events: none;
        }

        .avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 6px solid #ff6b35;
            margin: 0 auto 1.5rem;
            display: block;
            transition: transform 0.3s ease;
        }

        .avatar:hover {
            transform: rotate(5deg) scale(1.05);
        }

        .name {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
        }

        .title {
            font-size: 1.25rem;
            color: #ff6b35;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .bio {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto 1.5rem;
        }

        .location {
            display: inline-block;
            background: #fff;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .socials {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .social-link {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #ff6b35;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #e55a2b;
            transform: translateY(-2px);
        }

        .section {
            background: white;
            padding: 2.5rem;
            border-radius: 25px;
            margin-bottom: 2rem;
            border: 3px solid #2d2d2d;
            position: relative;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: #2d2d2d;
            display: inline-block;
            padding-bottom: 0.5rem;
            border-bottom: 4px solid #ff6b35;
        }

        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .skill-tag {
            background: #fff5e6;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
            color: #2d2d2d;
            border: 2px solid #2d2d2d;
            transition: all 0.2s ease;
        }

        .skill-tag:hover {
            background: #ffebb3;
            transform: scale(1.05);
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .project-card {
            background: #fef7f0;
            border: 3px solid #2d2d2d;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 8px 8px 0 #ff6b35;
        }

        .project-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #e0e0e0;
        }

        .project-content {
            padding: 1.5rem;
        }

        .project-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2d2d2d;
        }

        .project-description {
            color: #666;
            line-height: 1.5;
        }

        .experience-item, .education-item {
            padding: 1.5rem;
            background: #fef7f0;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border-left: 5px solid #ff6b35;
        }

        .experience-title, .education-degree {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 0.3rem;
        }

        .experience-company, .education-school {
            font-size: 1.1rem;
            color: #ff6b35;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .experience-meta, .education-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .experience-description, .education-description {
            color: #666;
            line-height: 1.6;
        }

        .about-section {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .name {
                font-size: 2rem;
            }
            
            .section {
                padding: 1.5rem;
            }
            
            .project-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header class="header">
            <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }}" class="avatar">
            <h1 class="name">{{ $data['name'] }}</h1>
            @if($data['title'])
                <p class="title">{{ $data['title'] }}</p>
            @endif
            @if($data['bio'])
                <p class="bio">{{ $data['bio'] }}</p>
            @endif
            @if($data['location'])
                <div class="location">📍 {{ $data['location'] }}</div>
            @endif
            
            @if($data['socials'] && count(array_filter($data['socials'])) > 0)
                <div class="socials">
                    @if($data['socials']['github'] ?? null)
                        <a href="{{ $data['socials']['github'] }}" class="social-link" target="_blank">GitHub</a>
                    @endif
                    @if($data['socials']['linkedin'] ?? null)
                        <a href="{{ $data['socials']['linkedin'] }}" class="social-link" target="_blank">LinkedIn</a>
                    @endif
                    @if($data['socials']['twitter'] ?? null)
                        <a href="{{ $data['socials']['twitter'] }}" class="social-link" target="_blank">Twitter</a>
                    @endif
                    @if($data['socials']['personal_website'] ?? null)
                        <a href="{{ $data['socials']['personal_website'] }}" class="social-link" target="_blank">Website</a>
                    @endif
                </div>
            @endif
        </header>

        <!-- About Me Section -->
        @if($data['about_me'])
            <section class="section">
                <h2 class="section-title">About Me</h2>
                <div class="about-section">{{ $data['about_me'] }}</div>
            </section>
        @endif

        <!-- Skills Section -->
        @if(!empty($data['skills']))
            <section class="section">
                <h2 class="section-title">Skills</h2>
                <div class="skills-grid">
                    @foreach($data['skills'] as $skill)
                        <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Projects Section -->
        @if(!empty($data['projects']))
            <section class="section">
                <h2 class="section-title">Projects</h2>
                <div class="project-grid">
                    @foreach($data['projects'] as $project)
                        <a href="{{ $project['url'] ?? '#' }}" class="project-card" @if($project['url'] ?? null) target="_blank" @endif>
                            @if($project['image_path'])
                                <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}" class="project-image">
                            @else
                                <div class="project-image" style="background: #ffebb3;"></div>
                            @endif
                            <div class="project-content">
                                <h3 class="project-title">{{ $project['title'] }}</h3>
                                @if($project['description'])
                                    <p class="project-description">{{ $project['description'] }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Experience Section -->
        @if(!empty($data['experiences']))
            <section class="section">
                <h2 class="section-title">Experience</h2>
                @foreach($data['experiences'] as $experience)
                    <div class="experience-item">
                        <h3 class="experience-title">{{ $experience['title'] }}</h3>
                        <div class="experience-company">{{ $experience['company'] }}</div>
                        <div class="experience-meta">
                            @if($experience['location'])
                                {{ $experience['location'] }} • 
                            @endif
                            {{ $experience['start_date'] }} - {{ $experience['end_date'] ?? 'Present' }}
                        </div>
                        @if($experience['description'])
                            <p class="experience-description">{{ $experience['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        <!-- Education Section -->
        @if(!empty($data['education']))
            <section class="section">
                <h2 class="section-title">Education</h2>
                @foreach($data['education'] as $edu)
                    <div class="education-item">
                        <h3 class="education-degree">{{ $edu['degree'] }}</h3>
                        <div class="education-school">{{ $edu['school'] }}</div>
                        <div class="education-meta">
                            @if($edu['field_of_study'])
                                {{ $edu['field_of_study'] }} • 
                            @endif
                            {{ $edu['start_date'] }} - {{ $edu['end_date'] ?? 'Present' }}
                        </div>
                        @if($edu['description'])
                            <p class="education-description">{{ $edu['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif
    </div>
</body>
</html>