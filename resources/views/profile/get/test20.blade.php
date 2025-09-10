<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $data['name'] }} — {{ $data['title'] }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body
  class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans transition-colors duration-200">
<a href="#main" class="sr-only focus:not-sr-only focus:translate-y-0 focus:opacity-100">Skip to content</a>
<header
  class="backdrop-blur-sm bg-white/60 dark:bg-gray-900/60 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <div class="flex flex-col leading-tight">
        <span class="text-lg font-semibold">{{ $data['name'] }}</span>
        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $data['title'] }}</span>
      </div>
    </div>
    <div class="flex items-center gap-4">
      <nav class="flex items-center gap-3" aria-label="social links">
        @if(!empty($data['socials']['github']))
          <a href="https://github.com/{{ $data['socials']['github'] }}" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="GitHub">
            <i class="bi bi-github text-xl"></i>
          </a>
        @endif
        @if(!empty($data['socials']['linkedin']))
          <a href="{{ $data['socials']['linkedin'] }}" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="LinkedIn">
            <i class="bi bi-linkedin text-xl"></i>
          </a>
        @endif
        @if(!empty($data['socials']['twitter']))
          <a href="https://twitter.com/{{ $data['socials']['twitter'] }}" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="Twitter">
            <i class="bi bi-twitter-x text-xl"></i>
          </a>
        @endif
        @if(!empty($data['socials']['personal_website']))
          <a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="Website">
            <i class="bi bi-globe text-xl"></i>
          </a>
        @endif
      </nav>
      <div class="relative">
        <div
          class="inline-flex divide-x rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
          <button id="theme-system" type="button" class="px-3 py-2 text-sm flex items-center gap-2 focus:outline-none"
                  aria-pressed="false" title="System">
            <i class="bi bi-display text-base"></i>
            <span class="sr-only">System</span>
          </button>
          <button id="theme-light" type="button" class="px-3 py-2 text-sm flex items-center gap-2 focus:outline-none"
                  aria-pressed="false" title="Light">
            <i class="bi bi-sun text-base"></i>
            <span class="sr-only">Light</span>
          </button>
          <button id="theme-dark" type="button" class="px-3 py-2 text-sm flex items-center gap-2 focus:outline-none"
                  aria-pressed="false" title="Dark">
            <i class="bi bi-moon-stars text-base"></i>
            <span class="sr-only">Dark</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</header>
<main id="main" class="max-w-7xl mx-auto px-6 py-10">
  <section class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
    <div class="md:col-span-1 flex flex-col items-center md:items-start gap-6">
      <img src="{{ $data['avatar_url'] }}" alt="{{ $data['name'] }} avatar"
           class="w-36 h-36 rounded-full ring-4 ring-white dark:ring-gray-900 object-cover shadow-md">
      <div class="text-center md:text-left">
        <h1 class="text-2xl font-bold">{{ $data['name'] }}</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $data['title'] }}</p>
        <p class="mt-3 text-sm leading-relaxed">{{ $data['bio'] }}</p>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
          <i class="bi bi-geo-alt-fill"></i>
          {{ $data['location'] }}
        </p>
        <a href="mailto:{{ $data['email'] }}"
           class="inline-block mt-4 px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none transition">Contact
          Me</a>
      </div>
      <div class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
        <h3 class="text-sm font-semibold mb-2">Quick Info</h3>
        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
          <li><span class="font-medium">Username:</span> {{ $data['username'] }}</li>
          <li><span class="font-medium">Email:</span> <a href="mailto:{{ $data['email'] }}"
                                                          class="underline">{{ $data['email'] }}</a></li>
          <li><span class="font-medium">Location:</span> {{ $data['location'] }}</li>
        </ul>
      </div>
    </div>
    <div class="md:col-span-2 space-y-8">
      <section class="prose prose-neutral dark:prose-invert max-w-none">
        <h2 class="text-xl font-semibold">About Me</h2>
        <p class="text-sm leading-relaxed">{!! nl2br(e($data['about_me'])) !!}</p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-4">Skills</h2>
        <div class="flex flex-wrap gap-2">
          @foreach($data['skills'] as $skill)
            <span
              class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-700 transition transform hover:-translate-y-0.5">{{ $skill }}</span>
          @endforeach
        </div>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-4">Projects</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach($data['projects'] as $project)
            <article
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col gap-3 hover:shadow-lg transition">
              <div class="flex items-start gap-3">
                @if(!empty($project['image_path']))
                  <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] }}"
                       class="w-16 h-12 rounded-md object-cover flex-shrink-0">
                @else
                  <div
                    class="w-16 h-12 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-sm font-medium text-gray-500 dark:text-gray-300">
                    No Image
                  </div>
                @endif
                <div class="flex-1">
                  <h3 class="text-sm font-semibold leading-snug">{{ $project['title'] }}</h3>
                  <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">{{ $project['description'] }}</p>
                </div>
              </div>
              <div class="mt-auto flex items-center justify-between">
                <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer"
                   class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Visit</a>
                <span class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $project['id'] }}</span>
              </div>
            </article>
          @endforeach
        </div>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-4">Experience</h2>
        <div class="space-y-4">
          @foreach($data['experiences'] as $exp)
            <div
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <h3 class="text-sm font-semibold">{{ $exp['title'] }}</h3>
                  <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">{{ $exp['company'] }} @if(!empty($exp['location']))
                      • <span class="text-gray-500 dark:text-gray-400">{{ $exp['location'] }}</span>@endif</p>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400 text-right">
                  <div>{{ $exp['start_date'] }} — {{ $exp['end_date'] }}</div>
                </div>
              </div>
              @if(!empty($exp['description']))
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $exp['description'] }}</p>
              @endif
            </div>
          @endforeach
        </div>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-4">Education</h2>
        <div class="space-y-4">
          @foreach($data['education'] as $edu)
            <div
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <h3 class="text-sm font-semibold">{{ $edu['school'] }}</h3>
                  <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">{{ $edu['degree'] }} • {{ $edu['field_of_study'] }}</p>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400 text-right">
                  <div>{{ $edu['start_date'] }} — {{ $edu['end_date'] }}</div>
                </div>
              </div>
              @if(!empty($edu['description']))
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $edu['description'] }}</p>
              @endif
            </div>
          @endforeach
        </div>
      </section>

    </div>
  </section>
  <footer class="mt-12 border-t border-gray-200 dark:border-gray-800 pt-6">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-sm text-gray-600 dark:text-gray-400">Powered by getmy.name from mtex.dev</p>
      <p class="text-sm text-gray-500 dark:text-gray-400">API requests: <span
          class="font-medium">{{ $data['api_request_count'] }}</span></p>
    </div>
  </footer>
</main>
<script>
  (function () {
    const key = 'theme';
    const systemButton = document.getElementById('theme-system');
    const lightButton = document.getElementById('theme-light');
    const darkButton = document.getElementById('theme-dark');
    const buttons = {
      system: systemButton,
      light: lightButton,
      dark: darkButton
    };

    function apply(theme, persist = true) {
      if (theme === 'dark') {
        document.documentElement.classList.add('dark');
      } else if (theme === 'light') {
        document.documentElement.classList.remove('dark');
      } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');
      }
      Object.keys(buttons).forEach(k => {
        buttons[k].setAttribute('aria-pressed', k === theme ? 'true' : 'false');
        if (k === theme) {
          buttons[k].classList.add('bg-white', 'dark:bg-gray-700');
        } else {
          buttons[k].classList.remove('bg-white', 'dark:bg-gray-700');
        }
      });
      if (persist) localStorage.setItem(key, theme);
    }

    const saved = localStorage.getItem(key) || 'system';
    apply(saved, false);
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
      const current = localStorage.getItem(key) || 'system';
      if (current === 'system') apply('system', false);
    });
    systemButton.addEventListener('click', () => apply('system'));
    lightButton.addEventListener('click', () => apply('light'));
    darkButton.addEventListener('click', () => apply('dark'));
  })();
</script>
</body>
</html>