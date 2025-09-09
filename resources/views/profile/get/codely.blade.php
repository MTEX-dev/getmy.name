<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $title = ($data['username'] ?? 'user') . '@terminal:~$ cd portfolio';
        $description = $data['bio'] ?? 'A portfolio presented as a code editor.';
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&display=swap" rel="stylesheet">
    <style>
        :root {
            --editor-bg: #1e1e1e;
            --sidebar-bg: #252526;
            --tab-inactive: #2d2d2d;
            --tab-active: #1e1e1e;
            --text-color: #d4d4d4;
            --accent-color: #569cd6;
            --string-color: #ce9178;
            --comment-color: #6a9955;
            --variable-color: #9cdcfe;
            --property-color: #d7ba7d;
            --number-color: #b5cea8;
            --markdown-header: #569cd6;
            --markdown-emphasis: #ce9178;
            --border-color: #3f3f46;
            --selection-color: rgba(66, 139, 202, 0.4);
            --scroll-thumb: #525252;
            --scroll-track: #2a2a2a;
            --footer-bg: #007acc;
            --tab-height: 35px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Fira Code', monospace;
            text-rendering: optimizeLegibility;
        }

        body {
            background-color: #1a1a1a;
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            flex-direction: column;
        }

        .editor-container {
            display: flex;
            flex-direction: column;
            width: 90vw;
            max-width: 1400px;
            height: 85vh;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
            border-radius: 8px;
            overflow: hidden;
        }

        .main-editor-content {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            padding-top: 10px;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 10px 15px;
            font-size: 0.9em;
            text-transform: uppercase;
            color: #ccc;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 5px;
        }

        .file-tree ul {
            list-style: none;
            padding: 0;
        }

        .file-tree li {
            padding: 8px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9em;
            color: #c5c5c5;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .file-tree li i {
            color: #888;
            font-size: 1.1em;
            width: 1.2em;
            text-align: center;
        }

        .file-tree li:hover {
            background-color: #373737;
        }

        .file-tree li.active-file {
            background-color: #0060c0;
            color: white;
            font-weight: 500;
        }
        .file-tree li.active-file i {
            color: white;
        }

        .editor-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: var(--editor-bg);
            overflow: hidden;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-left: 5px;
            -webkit-overflow-scrolling: touch;
            min-height: var(--tab-height);
            height: var(--tab-height);
            flex-shrink: 0;
        }
        .tabs::-webkit-scrollbar {
            height: 5px;
        }
        .tabs::-webkit-scrollbar-thumb {
            background-color: #4a4a4a;
            border-radius: 3px;
        }
        .tabs::-webkit-scrollbar-track {
            background: #2a2a2a;
        }

        .tab {
            padding: 8px 15px;
            cursor: pointer;
            background-color: var(--tab-inactive);
            border-right: 1px solid var(--border-color);
            border-left: 1px solid transparent;
            color: #999;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s ease, color 0.2s ease;
            position: relative;
            flex-shrink: 0;
        }

        .tab:hover:not(.active-tab) {
            background-color: #333;
            color: #d4d4d4;
        }

        .tab.active-tab {
            background-color: var(--editor-bg);
            color: var(--text-color);
            border-bottom: 1px solid transparent;
            z-index: 1;
            font-weight: 500;
        }

        .tab-close {
            margin-left: 10px;
            font-size: 0.7em;
            color: #999;
            transition: color 0.2s ease;
            padding: 3px;
            border-radius: 3px;
        }

        .tab-close:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .tab-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            white-space: pre-wrap;
            font-size: 0.95em;
            line-height: 1.5;
            position: relative;
            display: none;
            counter-reset: line-number;
            padding-left: 0;
        }

        .tab-content.active-content {
            display: block;
        }

        .line {
            display: flex;
            min-height: 1.5em;
            line-height: 1.5em;
        }

        .line-number {
            counter-increment: line-number;
            width: 40px;
            text-align: right;
            margin-right: 15px;
            color: #6c6c6c;
            user-select: none;
            flex-shrink: 0;
            padding-right: 10px;
            position: sticky;
            left: 0;
            background-color: var(--editor-bg);
            border-right: 1px solid transparent;
        }
        .line:hover .line-number {
            color: #888;
        }
        .line.highlighted .line-number {
            background-color: var(--selection-color);
            color: white;
        }
        .line.highlighted .line-code {
             background-color: var(--selection-color);
        }

        .line-code {
            flex-grow: 1;
        }
        .indent-1 { margin-left: 2ch; }
        .indent-2 { margin-left: 4ch; }
        .indent-3 { margin-left: 6ch; }
        .indent-4 { margin-left: 8ch; }


        .keyword { color: var(--accent-color); }
        .string { color: var(--string-color); }
        .comment { color: var(--comment-color); }
        .variable { color: var(--variable-color); }
        .property { color: var(--property-color); }
        .number { color: var(--number-color); }
        .operator { color: #d4d4d4; }
        .type { color: #4ec9b0; }
        .function { color: #dcdcaa; }
        .tag { color: #569cd6; }
        .attribute { color: #9cdcfe; }
        .value { color: #ce9178; }
        .boolean { color: #569cd6; }

        .markdown-header { color: var(--markdown-header); font-weight: bold; }
        .markdown-link-text { color: var(--accent-color); text-decoration: underline; }
        .markdown-list-item { color: var(--text-color); }
        .markdown-emphasis { color: var(--markdown-emphasis); font-style: italic; }
        .markdown-strong { font-weight: bold; }
        .markdown-code-block {
            background-color: #0d0d0d;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            overflow-x: auto;
            border: 1px solid #333;
        }

        .sidebar::-webkit-scrollbar, .tab-content::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        .sidebar::-webkit-scrollbar-track, .tab-content::-webkit-scrollbar-track {
            background: var(--scroll-track);
        }
        .sidebar::-webkit-scrollbar-thumb, .tab-content::-webkit-scrollbar-thumb {
            background-color: var(--scroll-thumb);
            border-radius: 5px;
            border: 2px solid var(--scroll-track);
        }
        .sidebar::-webkit-scrollbar-thumb:hover, .tab-content::-webkit-scrollbar-thumb:hover {
            background-color: #6a6a6a;
        }

        .footer-bar {
            width: 90vw;
            max-width: 1400px;
            background-color: var(--footer-bg);
            color: white;
            padding: 5px 15px;
            font-size: 0.8em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            border-radius: 0 0 8px 8px;
            height: 28px;
        }
        .editor-container {
             border-bottom-left-radius: 0;
             border-bottom-right-radius: 0;
             border-bottom: none;
        }
        .footer-bar a {
            color: white;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-bar a:hover {
            color: #d4d4d4;
            text-decoration: underline;
        }

        .footer-bar .left-items, .footer-bar .right-items {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .footer-bar i {
            margin-right: 5px;
            opacity: 0.8;
        }
        .footer-bar span {
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .editor-container {
                width: 95vw;
                height: 90vh;
            }
            .sidebar {
                width: 180px;
                display: none;
            }
            body.sidebar-open .sidebar {
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                z-index: 10;
                box-shadow: 2px 0 10px rgba(0,0,0,0.5);
            }
            .footer-bar {
                width: 95vw;
                font-size: 0.7em;
                padding: 5px 10px;
            }
            .footer-bar .left-items, .footer-bar .right-items {
                gap: 8px;
            }
            .footer-bar i {
                margin-right: 3px;
            }
            .tab {
                padding: 8px 10px;
            }
            .tab-close {
                margin-left: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="editor-container">
        <div class="main-editor-content">
            <div class="sidebar">
                <div class="sidebar-header">Explorer</div>
                <ul class="file-tree">
                    <li data-tab="README.md" class="active-file"><i class="bi bi-file-earmark-text"></i>README.md</li>
                    <li data-tab="about_me.html"><i class="bi bi-filetype-html"></i>about_me.html</li>
                    <li data-tab="skills.js"><i class="bi bi-filetype-js"></i>skills.js</li>
                    <li data-tab="projects.json"><i class="bi bi-filetype-json"></i>projects.json</li>
                    <li data-tab="experience.json"><i class="bi bi-filetype-json"></i>experience.json</li>
                    <li data-tab="education.json"><i class="bi bi-filetype-json"></i>education.json</li>
                    <li data-tab="contact.html"><i class="bi bi-envelope"></i>contact.html</li>
                    <li data-tab="socials.json"><i class="bi bi-share"></i>socials.json</li>
                    <li data-tab="style.css"><i class="bi bi-filetype-css"></i>style.css</li>
                </ul>
            </div>
            <div class="editor-area">
                <div class="tabs">
                    <div class="tab active-tab" data-tab="README.md">README.md <i class="bi bi-x-lg tab-close" onclick="window.closeTab(event, 'README.md')"></i></div>
                </div>
                <div class="tab-content active-content" id="content-README.md">
<span data-raw-line><span class="markdown-header"># {{ $data['name'] ?? ($data['username'] ?? 'Anonymous') }}</span></span>
<span data-raw-line></span>
<span data-raw-line><span class="comment">// A brief introduction to my professional profile.</span></span>
<span data-raw-line><span class="markdown-emphasis">A {{ $data['title'] ?? 'Software Developer' }} based in {{ $data['location'] ?? 'The Internet' }}.</span></span>
<span data-raw-line></span>
<span data-raw-line><span class="comment">// Explore 'about_me.html' for a deeper dive.</span></span>
<span data-raw-line><span class="markdown-header">## Bio</span></span>
<span data-raw-line>{{ $data['bio'] ?? 'Loading...' }}</span>
<span data-raw-line></span>
<span data-raw-line><span class="comment">// Important links to connect or view my work.</span></span>
<span data-raw-line><span class="markdown-header">## Quick Links</span></span>
@if(isset($data['socials']['github']))
<span data-raw-line>- <span class="markdown-link-text">GitHub</span>: [{{ $data['socials']['github'] }}](https://github.com/{{ $data['socials']['github'] }})</span>
@endif
@if(isset($data['socials']['linkedin']))
<span data-raw-line>- <span class="markdown-link-text">LinkedIn</span>: [{{ $data['socials']['linkedin'] }}](https://linkedin.com/in/{{ $data['socials']['linkedin'] }})</span>
@endif
@if(isset($data['socials']['twitter']))
<span data-raw-line>- <span class="markdown-link-text">Twitter</span>: [{{ $data['socials']['twitter'] }}](https://twitter.com/{{ $data['socials']['twitter'] }})</span>
@endif
@if(isset($data['email']))
<span data-raw-line>- <span class="markdown-link-text">Email</span>: [{{ $data['email'] }}](mailto:{{ $data['email'] }})</span>
@endif
@if(isset($data['socials']['personal_website']))
<span data-raw-line>- <span class="markdown-link-text">Website</span>: [{{ parse_url($data['socials']['personal_website'], PHP_URL_HOST) }}]({{ $data['socials']['personal_website'] }})</span>
@endif
                </div>

                <div class="tab-content" id="content-about_me.html">
<span data-raw-line><span class="comment">&lt;!-- about_me.html: Detailed description of my background and passion. --&gt;</span></span>
<span data-raw-line><span class="tag">&lt;section</span> <span class="attribute">id</span>=<span class="string">"about"</span><span class="tag">&gt;</span></span>
<span data-raw-line><span class="indent-1">  <span class="tag">&lt;h2&gt;</span>About Me<span class="tag">&lt;/h2&gt;</span></span></span>
<span data-raw-line><span class="indent-1">  <span class="tag">&lt;p&gt;</span>{!! nl2br(e($data['about_me'] ?? 'A passionate developer eager to build awesome things.')) !!}<span class="tag">&lt;/p&gt;</span></span></span>
<span data-raw-line><span class="tag">&lt;/section&gt;</span></span>
                </div>

                <div class="tab-content" id="content-skills.js">
<span data-raw-line><span class="comment">// skills.js: A list of technologies and languages I am proficient in.</span></span>
<span data-raw-line><span class="keyword">const</span> <span class="variable">mySkills</span> = [</span>
@forelse($data['skills'] as $skill)
<span data-raw-line><span class="indent-1">  <span class="string">'{{ $skill }}'</span>,</span></span>
@empty
<span data-raw-line><span class="indent-1">  <span class="comment">// No skills currently listed.</span></span></span>
@endforelse
<span data-raw-line>];</span>
<span data-raw-line></span>
<span data-raw-line><span class="comment">// In a real app, this might render them dynamically.</span></span>
<span data-raw-line><span class="function">function</span> <span class="function">displaySkills</span>() {</span>
<span data-raw-line><span class="indent-1">  <span class="variable">console</span>.<span class="function">log</span>(<span class="string">'My technical arsenal:'</span>, <span class="variable">mySkills</span>);</span></span>
<span data-raw-line>}</span>
                </div>

                <div class="tab-content" id="content-projects.json">
<span data-raw-line>{</span>
<span data-raw-line><span class="indent-1">  <span class="property">"projects"</span>: [ <span class="comment">// Details about my notable projects.</span></span></span>
@forelse($data['projects'] as $index => $project)
<span data-raw-line><span class="indent-2">    {</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"title"</span>: <span class="string">"{{ $project['title'] ?? 'Untitled Project' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"description"</span>: <span class="string">"{{ $project['description'] ?? 'No description provided.' }}"</span>,</span></span>
@if(!empty($project['url']))
<span data-raw-line><span class="indent-3">      <span class="property">"url"</span>: <span class="string">"{{ $project['url'] }}"</span></span></span>
@endif
@if(!empty($project['image_path']))
<span data-raw-line><span class="indent-3">      <span class="property">"image_path"</span>: <span class="string">"{{ $project['image_path'] }}"</span></span></span>
@endif
<span data-raw-line><span class="indent-2">    }{{ $loop->last ? '' : ',' }}</span></span>
@empty
<span data-raw-line><span class="indent-2">    <span class="comment">// No projects defined yet.</span></span></span>
@endforelse
<span data-raw-line><span class="indent-1">  ]</span></span>
<span data-raw-line>}</span>
                </div>

                <div class="tab-content" id="content-experience.json">
<span data-raw-line>{</span>
<span data-raw-line><span class="indent-1">  <span class="property">"experiences"</span>: [ <span class="comment">// My professional work history.</span></span></span>
@forelse($data['experiences'] as $index => $exp)
<span data-raw-line><span class="indent-2">    {</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"title"</span>: <span class="string">"{{ $exp['title'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"company"</span>: <span class="string">"{{ $exp['company'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"start_date"</span>: <span class="string">"{{ $exp['start_date'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"end_date"</span>: <span class="string">"{{ $exp['end_date'] ?? 'Present' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"location"</span>: <span class="string">"{{ $exp['location'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"description"</span>: <span class="string">"{{ $exp['description'] ?? 'No description.' }}"</span></span></span>
<span data-raw-line><span class="indent-2">    }{{ $loop->last ? '' : ',' }}</span></span>
@empty
<span data-raw-line><span class="indent-2">    <span class="comment">// No work experience defined.</span></span></span>
@endforelse
<span data-raw-line><span class="indent-1">  ]</span></span>
<span data-raw-line>}</span>
                </div>

                <div class="tab-content" id="content-education.json">
<span data-raw-line>{</span>
<span data-raw-line><span class="indent-1">  <span class="property">"education"</span>: [ <span class="comment">// My academic background.</span></span></span>
@forelse($data['education'] as $index => $edu)
<span data-raw-line><span class="indent-2">    {</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"degree"</span>: <span class="string">"{{ $edu['degree'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"field_of_study"</span>: <span class="string">"{{ $edu['field_of_study'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"school"</span>: <span class="string">"{{ $edu['school'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"start_date"</span>: <span class="string">"{{ $edu['start_date'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"end_date"</span>: <span class="string">"{{ $edu['end_date'] ?? 'N/A' }}"</span>,</span></span>
<span data-raw-line><span class="indent-3">      <span class="property">"description"</span>: <span class="string">"{{ $edu['description'] ?? 'No description.' }}"</span></span></span>
<span data-raw-line><span class="indent-2">    }{{ $loop->last ? '' : ',' }}</span></span>
@empty
<span data-raw-line><span class="indent-2">    <span class="comment">// No education records defined.</span></span></span>
@endforelse
<span data-raw-line><span class="indent-1">  ]</span></span>
<span data-raw-line>}</span>
                </div>

                <div class="tab-content" id="content-contact.html">
<span data-raw-line><span class="comment">&lt;!-- contact.html: Ways to connect with me. --&gt;</span></span>
<span data-raw-line><span class="tag">&lt;section</span> <span class="attribute">id</span>=<span class="string">"contact"</span><span class="tag">&gt;</span></span>
<span data-raw-line><span class="indent-1">  <span class="tag">&lt;h2&gt;</span>Get in Touch<span class="tag">&lt;/h2&gt;</span></span></span>
<span data-raw-line><span class="indent-1">  <span class="tag">&lt;div</span> <span class="attribute">class</span>=<span class="string">"contact-info"</span><span class="tag">&gt;</span></span></span>
@if(!empty($data['email']))
<span data-raw-line><span class="indent-2">    <span class="tag">&lt;p&gt;</span><span class="tag">&lt;strong&gt;</span>Email:<span class="tag">&lt;/strong&gt;</span> <span class="tag">&lt;a</span> <span class="attribute">href</span>=<span class="string">"mailto:{{ $data['email'] }}"</span><span class="tag">&gt;</span>{{ $data['email'] }}<span class="tag">&lt;/a&gt;</span><span class="tag">&lt;/p&gt;</span></span></span>
@endif
@if(!empty($data['location']))
<span data-raw-line><span class="indent-2">    <span class="tag">&lt;p&gt;</span><span class="tag">&lt;strong&gt;</span>Location:<span class="tag">&lt;/strong&gt;</span> {{ $data['location'] }}<span class="tag">&lt;/p&gt;</span></span></span>
@endif
<span data-raw-line><span class="indent-2">    <span class="tag">&lt;p&gt;</span><span class="tag">&lt;strong&gt;</span>Availability:<span class="tag">&lt;/strong&gt;</span> Open for new opportunities!<span class="tag">&lt;/p&gt;</span></span></span>
<span data-raw-line><span class="indent-1">  <span class="tag">&lt;/div&gt;</span></span></span>
<span data-raw-line><span class="tag">&lt;/section&gt;</span></span>
                </div>

                <div class="tab-content" id="content-socials.json">
<span data-raw-line>{</span>
<span data-raw-line><span class="indent-1">  <span class="property">"socials"</span>: { <span class="comment">// My social media and external links.</span></span></span>
@forelse($data['socials'] as $key => $value)
<span data-raw-line><span class="indent-2">    <span class="property">"{{ $key }}"</span>: <span class="string">"{{ $value }}"</span>{{ $loop->last ? '' : ',' }}</span></span>
@empty
<span data-raw-line><span class="indent-2">    <span class="comment">// No social links defined.</span></span></span>
@endforelse
<span data-raw-line><span class="indent-1">  }</span></span>
<span data-raw-line>}</span>
                </div>

                <div class="tab-content" id="content-style.css">
<span data-raw-line><span class="comment">/* style.css: Core styling for the Codely theme. */</span></span>
<span data-raw-line><span class="keyword">body</span> {</span>
<span data-raw-line><span class="indent-1">  <span class="property">font-family</span>: <span class="string">'Fira Code'</span>, <span class="string">monospace</span>;</span></span>
<span data-raw-line><span class="indent-1">  <span class="property">background-color</span>: <span class="number">#1a1a1a</span>;</span></span>
<span data-raw-line><span class="indent-1">  <span class="property">color</span>: <span class="variable">var(--text-color)</span>;</span></span>
<span data-raw-line>}</span>
<span data-raw-line></span>
<span data-raw-line><span class="keyword">.editor-container</span> {</span>
<span data-raw-line><span class="indent-1">  <span class="property">border-radius</span>: <span class="number">8px</span>;</span></span>
<span data-raw-line><span class="indent-1">  <span class="property">box-shadow</span>: <span class="number">0</span> <span class="number">10px</span> <span class="number">30px</span> <span class="function">rgba</span>(<span class="number">0</span>, <span class="number">0</span>, <span class="number">0</span>, <span class="number">0.5</span>);</span></span>
<span data-raw-line>}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bar">
        <div class="left-items">
            <span title="Branch"><i class="bi bi-git"></i>main*</span>
            <span title="Issues"><i class="bi bi-bug"></i>0</span>
            <span title="Warnings"><i class="bi bi-exclamation-triangle"></i>0</span>
        </div>
        <div class="right-items">
            <span id="line-col-indicator">Ln 1, Col 1</span>
            <span>Spaces: 4</span>
            <span>UTF-8</span>
            <span>CRLF</span>
            <!--span title="Powered by getmy.name from mtex.dev">Powered by<a href="https://getmy.name" target="_blank">getmy.name</a> & <a href="https://mtex.dev" target="_blank">mtex.dev</a></span-->
            <span><a href="https://getmy.name" target="_blank">getmy.name</a></span>
            <span><a href="https://mtex.dev" target="_blank">mtex.dev</a></span>
            @if(isset($data['username']))
                <span title="User"><i class="bi bi-person"></i>{{ $data['username'] }}</span>
            @endif
            @if(isset($data['api_request_count']))
                <span title="API Requests"><i class="bi bi-cloud-arrow-up"></i>{{ $data['api_request_count'] }}</span>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileTree = document.querySelector('.file-tree');
            const tabsContainer = document.querySelector('.tabs');
            const contents = document.querySelectorAll('.tab-content');
            const lineColIndicator = document.getElementById('line-col-indicator');
            let openTabs = new Set(['README.md']);
            let currentActiveTab = 'README.md';

            window.closeTab = function(event, fileName) {
                event.stopPropagation();
                const tabToRemove = document.querySelector(`.tab[data-tab="${fileName}"]`);
                if (tabToRemove && fileName !== 'README.md') {
                    const wasActive = tabToRemove.classList.contains('active-tab');
                    tabToRemove.remove();
                    const contentToHide = document.getElementById(`content-${fileName}`);
                    if (contentToHide) contentToHide.classList.remove('active-content');
                    const fileTreeItem = document.querySelector(`.file-tree li[data-tab="${fileName}"]`);
                    if (fileTreeItem) fileTreeItem.classList.remove('active-file');
                    openTabs.delete(fileName);

                    if (wasActive) {
                        const remainingTabs = Array.from(tabsContainer.querySelectorAll('.tab'));
                        if (remainingTabs.length > 0) {
                            activateTab(remainingTabs[remainingTabs.length - 1].getAttribute('data-tab'));
                        } else {
                            openTab('README.md');
                        }
                    }
                }
            };

            function updateLineNumbersAndHighlight(contentDiv) {
                const lines = contentDiv.querySelectorAll('.line');
                lines.forEach((line, index) => {
                    const lineNumberSpan = line.querySelector('.line-number');
                    if (lineNumberSpan) {
                        lineNumberSpan.textContent = (index + 1).toString();
                    }
                    line.removeEventListener('click', handleLineClick);
                    line.addEventListener('click', handleLineClick);
                });
            }

            function handleLineClick(event) {
                document.querySelectorAll('.tab-content.active-content .line').forEach(line => {
                    line.classList.remove('highlighted');
                });
                const clickedLine = event.currentTarget;
                clickedLine.classList.add('highlighted');
                updateLineColIndicator(clickedLine);
            }

            function updateLineColIndicator(activeLine = null) {
                if (!activeLine) {
                    activeLine = document.querySelector('.tab-content.active-content .line.highlighted');
                    if (!activeLine) {
                        activeLine = document.querySelector('.tab-content.active-content .line');
                        if (activeLine) activeLine.classList.add('highlighted');
                    }
                }
                if (activeLine) {
                    const lineNumber = activeLine.querySelector('.line-number').textContent;
                    const lineCode = activeLine.querySelector('.line-code').textContent;
                    const columnNumber = lineCode.search(/\S|$/) + 1;
                    lineColIndicator.textContent = `Ln ${lineNumber}, Col ${columnNumber}`;
                } else {
                    lineColIndicator.textContent = 'Ln -, Col -';
                }
            }

            function openTab(fileName) {
                if (!openTabs.has(fileName)) {
                    const newTab = document.createElement('div');
                    newTab.classList.add('tab');
                    newTab.setAttribute('data-tab', fileName);
                    newTab.innerHTML = `${fileName} <i class="bi bi-x-lg tab-close" onclick="window.closeTab(event, '${fileName}')"></i>`;
                    tabsContainer.appendChild(newTab);
                    openTabs.add(fileName);
                }
                activateTab(fileName);
            }

            function activateTab(fileName) {
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('active-tab');
                });
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active-content');
                });
                document.querySelectorAll('.file-tree li').forEach(fileItem => {
                    fileItem.classList.remove('active-file');
                });

                const activeTabElement = document.querySelector(`.tab[data-tab="${fileName}"]`);
                const activeContentElement = document.getElementById(`content-${fileName}`);
                const activeFileTreeElement = document.querySelector(`.file-tree li[data-tab="${fileName}"]`);

                if (activeTabElement) activeTabElement.classList.add('active-tab');
                if (activeContentElement) activeContentElement.classList.add('active-content');
                if (activeFileTreeElement) activeFileTreeElement.classList.add('active-file');

                currentActiveTab = fileName;
                updateLineNumbersAndHighlight(activeContentElement);
                updateLineColIndicator();
            }

            fileTree.addEventListener('click', (event) => {
                const targetLi = event.target.closest('li');
                if (targetLi) {
                    const fileName = targetLi.getAttribute('data-tab');
                    openTab(fileName);
                }
            });

            tabsContainer.addEventListener('click', (event) => {
                const targetTab = event.target.closest('.tab');
                if (targetTab && !event.target.classList.contains('tab-close')) {
                    const fileName = targetTab.getAttribute('data-tab');
                    activateTab(fileName);
                }
            });

            contents.forEach(contentDiv => {
                const rawHtml = contentDiv.innerHTML;
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = rawHtml;

                let processedHtml = '';
                Array.from(tempDiv.childNodes).forEach(node => {
                    if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'SPAN' && node.hasAttribute('data-raw-line')) {
                        let lineContent = node.innerHTML;
                        let leadingWhitespaceMatch = lineContent.match(/^(\s*)/);
                        let indentLevel = 0;
                        if (leadingWhitespaceMatch && leadingWhitespaceMatch[1]) {
                            indentLevel = Math.floor(leadingWhitespaceMatch[1].length / 2);
                        }
                        let indentClass = indentLevel > 0 ? `indent-${indentLevel}` : '';
                        let trimmedLineContent = lineContent.replace(/^\s*/, '');
                        processedHtml += `<div class="line"><span class="line-number"></span><span class="line-code ${indentClass}">${trimmedLineContent}</span></div>`;
                    } else if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
                        node.textContent.split('\n').forEach(lineText => {
                            if (lineText.trim() !== '') {
                                let leadingWhitespaceMatch = lineText.match(/^(\s*)/);
                                let indentLevel = 0;
                                if (leadingWhitespaceMatch && leadingWhitespaceMatch[1]) {
                                    indentLevel = Math.floor(leadingWhitespaceMatch[1].length / 2);
                                }
                                let indentClass = indentLevel > 0 ? `indent-${indentLevel}` : '';
                                let trimmedLineText = lineText.replace(/^\s*/, '');
                                processedHtml += `<div class="line"><span class="line-number"></span><span class="line-code ${indentClass}">${trimmedLineText}</span></div>`;
                            }
                        });
                    }
                });
                contentDiv.innerHTML = processedHtml;
            });

            activateTab('README.md');
        });
    </script>
</body>
</html>