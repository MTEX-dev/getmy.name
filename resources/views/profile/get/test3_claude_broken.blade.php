{{-- resources/views/portfolio.blade.php --}}
<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $data['name'] ?? 'Portfolio' }} — {{ $data['title'] ?? '' }}</title>

  {{-- Vite (Tailwind included via your build) --}}
  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Bootstrap Icons CDN --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    /* Small custom enhancements for "mosaic" feel */
    .mosaic-card {
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
    }
    .hero-tilt {
      transform: rotate(-1.5deg);
    }
    @media (min-width: 1024px) {
      .hero-tilt { transform: rotate(-2deg) translateY(-6px); }
    }
  </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-200">
  <div id="aurora-root" class="min-h-screen flex flex-col">

    {{-- Topbar with theme controls --}}
    <header class="w-full py-4 px-6 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg mosaic-card bg-white/60 dark:bg-gray-800/60 flex items-center justify-center text-xl font-semibold shadow-sm">
          {{ isset($data['name']) ? strtoupper(substr($data['name'],0,1)) : 'P' }}
        </div>
        <div>
          <div class="text-sm font-medium">{{ $data['name'] ?? 'Your Name' }}</div>
          <div class="text-xs text-gray-600 dark:text-gray-300">{{ $data['title'] ?? '' }}</div>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <nav class="hidden sm:flex gap-2 items-center">
          <a href="#projects" class="text-sm hover:underline">Projects</a>
          <a href="#experience" class="text-sm hover:underline">Experience</a>
          <a href="#education" class="text-sm hover:underline">Education</a>
        </nav>

        <div class="flex items-center gap-2 p-1 rounded-lg mosaic-card bg-white/60 dark:bg-gray-800/60">
          <button data-theme="system" class="theme-btn p-2 rounded-md" title="Follow system">
            <i class="bi bi-laptop"></i>
          </button>
          <button data-theme="light" class="theme-btn p-2 rounded-md" title="Light mode">
            <i class="bi bi-sun"></i>
          </button>
          <button data-theme="dark" class="theme-btn p-2 rounded-md" title="Dark mode">
            <i class="bi bi-moon"></i>
          </button>
        </div>
      </div>
    </header>

    {{-- Main mosaic container --}}
    <main class="flex-1 px-4 sm:px-6 lg:px-12 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
      {{-- Hero (floating) --}}
      <section class="lg:col-span-12 relative">
        <div class="max-w-6xl mx-auto relative">
          <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 w-[92%] lg:w-full">
            <div class="hero-tilt mosaic-card rounded-2xl shadow-xl p-6 lg:p-8 bg-white/80 dark:bg-gray-800/70 border border-gray-100 dark:border-gray-700">
              <div class="flex flex-col lg:flex-row items-center gap-6">
                <img src="{{ $data['avatar_url'] ?? 'https://via.placeholder.com/160' }}"
                     alt="{{ $data['name'] ?? 'Avatar' }}"
                     class="w-28 h-28 lg:w-36 lg:h-36 rounded-xl object-cover shadow-md border-2 border-white dark:border-gray-900"/>

                <div class="flex-1">
                  <div class="flex items-center justify-between gap-4">
                    <div>
                      <h1 class="text-2xl lg:text-3xl font-bold leading-tight">
                        {{ $data['name'] ?? 'Your Name' }}
                      </h1>
                      <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                        {{ $data['title'] ?? '' }}
                      </p>
                    </div>

                    <div class="hidden md:flex flex-col items-end text-right">
                      <div class="text-sm text-gray-500 dark:text-gray-400">{{ $data['bio'] ?? '' }}</div>
                      <a href="{{ $data['socials']['personal_website'] ?? '#' }}" class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                        <i class="bi bi-box-arrow-up-right"></i> Visit
                      </a>
                    </div>
                  </div>

                  <p class="mt-4 text-sm text-gray-700 dark:text-gray-200 max-w-2xl">
                    {{ $data['about_me'] ?? $data['bio'] ?? '' }}
                  </p>

                  {{-- Quick socials (mobile & small screens) --}}
                  <div class="flex gap-3 mt-4 md:hidden">
                    @php
                      $social = $data['socials'] ?? [];
                      function social_url($key, $val) {
                          if (!$val) return '#';
                          if (Str::startsWith($val, ['http://','https://'])) return $val;
                          if ($key === 'twitter') {
                              $handle = ltrim($val, '@');
                              return 'https://twitter.com/'.$handle;
                          }
                          if ($key === 'github') {
                              return (Str::contains($val, '/') ? $val : 'https://github.com/'.$val);
                          }
                          if ($key === 'linkedin') {
                              return (Str::contains($val, '/') ? $val : 'https://www.linkedin.com/in/'.$val);
                          }
                          return $val;
                      }
                    @endphp

                    @if(!empty($social['github']))
                      <a href="{{ social_url('github', $social['github']) }}" target="_blank" rel="noopener" class="p-2 rounded-md mosaic-card bg-white/70 dark:bg-gray-800/60">
                        <i class="bi bi-github"></i>
                      </a>
                    @endif
                    @if(!empty($social['linkedin']))
                      <a href="{{ social_url('linkedin', $social['linkedin']) }}" target="_blank" rel="noopener" class="p-2 rounded-md mosaic-card bg-white/70 dark:bg-gray-800/60">
                        <i class="bi bi-linkedin"></i>
                      </a>
                    @endif
                    @if(!empty($social['twitter']))
                      <a href="{{ social_url('twitter', $social['twitter']) }}" target="_blank" rel="noopener" class="p-2 rounded-md mosaic-card bg-white/70 dark:bg-gray-800/60">
                        <i class="bi bi-twitter"></i>
                      </a>
                    @endif
                  </div>

                </div>
              </div>
            </div>
          </div>

          {{-- Grid beneath hero: a mosaic of cards --}}
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-28 lg:mt-32 max-w-6xl mx-auto">
            {{-- Left column: Skills + Contact --}}
            <div class="space-y-6 lg:col-span-1">
              <div class="mosaic-card rounded-2xl p-5 shadow-sm bg-white/60 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-semibold">Skills</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                  @foreach($data['skills'] ?? [] as $skill)
                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">{{ $skill }}</span>
                  @endforeach
                </div>
              </div>

              <div class="mosaic-card rounded-2xl p-5 shadow-sm bg-white/60 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-semibold">Contact</h3>
                <div class="mt-3 text-sm text-gray-600 dark:text-gray-300 space-y-2">
                  @if(!empty($data['socials']['personal_website']))
                    <div><i class="bi bi-globe me-2"></i><a href="{{ $data['socials']['personal_website'] }}" target="_blank" rel="noopener" class="hover:underline">{{ $data['socials']['personal_website'] }}</a></div>
                  @endif
                  @if(!empty($data['socials']['github']))
                    <div><i class="bi bi-github me-2"></i><a href="{{ (Str::startsWith($data['socials']['github'], ['http://','https://']) ? $data['socials']['github'] : 'https://github.com/'.$data['socials']['github']) }}" target="_blank" rel="noopener" class="hover:underline">Github</a></div>
                  @endif
                  @if(!empty($data['socials']['linkedin']))
                    <div><i class="bi bi-linkedin me-2"></i><a href="{{ (Str::startsWith($data['socials']['linkedin'], ['http://','https://']) ? $data['socials']['linkedin'] : 'https://www.linkedin.com/in/'.$data['socials']['linkedin']) }}" target="_blank" rel="noopener" class="hover:underline">LinkedIn</a></div>
                  @endif
                </div>
              </div>
            </div>

            {{-- Middle column: Projects (big) --}}
            <div id="projects" class="lg:col-span-2 space-y-6">
              <div class="rounded-2xl p-5 mosaic-card bg-white/80 dark:bg-gray-800/70 border border-gray-100 dark:border-gray-700 shadow">
                <div class="flex items-center justify-between">
                  <h2 class="text-xl font-bold">Projects</h2>
                  <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($data['projects'] ?? []) }} projects</span>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                  @foreach($data['projects'] ?? [] as $project)
                    <article class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 mosaic-card bg-white/60 dark:bg-gray-800/60 p-4">
                      <div class="flex flex-col h-full">
                        @if(!empty($project['image_path']))
                          <img src="{{ $project['image_path'] }}" alt="{{ $project['title'] ?? 'Project' }}" class="w-full h-36 object-cover rounded-md mb-3">
                        @endif
                        <h3 class="font-semibold">{{ $project['title'] ?? 'Untitled' }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 flex-1">{{ $project['description'] ?? '' }}</p>
                        <div class="mt-3 flex items-center justify-between">
                          @if(!empty($project['url']))
                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener" class="text-sm font-medium inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:underline">
                              View <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                          @else
                            <span class="text-xs text-gray-500">No link</span>
                          @endif
                          <span class="text-xs text-gray-500">{{ !empty($project['image_path']) ? 'Showcase' : 'Code' }}</span>
                        </div>
                      </div>
                    </article>
                  @endforeach
                </div>
              </div>

              {{-- Experience --}}
              <div id="experience" class="rounded-2xl p-5 mosaic-card bg-white/80 dark:bg-gray-800/70 border border-gray-100 dark:border-gray-700 shadow">
                <h2 class="text-xl font-bold">Experience</h2>
                <div class="mt-4 space-y-4">
                  @foreach($data['experiences'] ?? [] as $exp)
                    @php
                      try {
                        $start = \Carbon\Carbon::parse($exp['start_date'])->format('M Y');
                        $end = $exp['end_date'] ? \Carbon\Carbon::parse($exp['end_date'])->format('M Y') : 'Present';
                      } catch (\Exception $e) {
                        $start = $exp['start_date'] ?? '';
                        $end = $exp['end_date'] ?? '';
                      }
                    @endphp
                    <div class="flex items-start gap-4">
                      <div class="w-2.5 h-2.5 rounded-full bg-primary-600 mt-2"></div>
                      <div class="flex-1">
                        <div class="flex items-center justify-between">
                          <div>
                            <div class="font-semibold">{{ $exp['title'] ?? '' }} — <span class="text-sm text-gray-600 dark:text-gray-300 font-normal">{{ $exp['company'] ?? '' }}</span></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $exp['location'] ?? '' }}</div>
                          </div>
                          <div class="text-xs text-gray-500 dark:text-gray-400">{{ $start }} — {{ $end }}</div>
                        </div>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-200">{{ $exp['description'] ?? '' }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              {{-- Education --}}
              <div id="education" class="rounded-2xl p-5 mosaic-card bg-white/80 dark:bg-gray-800/70 border border-gray-100 dark:border-gray-700 shadow">
                <h2 class="text-xl font-bold">Education</h2>
                <div class="mt-4 space-y-4">
                  @foreach($data['education'] ?? [] as $edu)
                    @php
                      try {
                        $s = \Carbon\Carbon::parse($edu['start_date'])->format('Y');
                        $e = \Carbon\Carbon::parse($edu['end_date'])->format('Y');
                      } catch (\Exception $e) {
                        $s = $edu['start_date'] ?? '';
                        $e = $edu['end_date'] ?? '';
                      }
                    @endphp
                    <div class="flex items-start gap-4">
                      <div class="w-2.5 h-2.5 rounded-full bg-primary-600 mt-2"></div>
                      <div class="flex-1">
                        <div class="font-semibold">{{ $edu['degree'] ?? '' }} — <span class="text-sm text-gray-600 dark:text-gray-300 font-normal">{{ $edu['school'] ?? '' }}</span></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $edu['field_of_study'] ?? '' }} • {{ $s }} — {{ $e }}</div>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-200">{{ $edu['description'] ?? '' }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

          </div> {{-- end mosaic grid --}}
        </div>
      </section>
    </main>

    {{-- Footer --}}
    <footer class="py-6 px-6">
      <div class="max-w-6xl mx-auto text-center text-sm text-gray-600 dark:text-gray-300">
        <span>Powered by <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://getmy.name" target="_blank" rel="noopener">getmy.name</a> from <a class="text-primary-600 dark:text-primary-400 hover:underline" href="https://mtex.dev" target="_blank" rel="noopener">mtex.dev</a></span>
      </div>
    </footer>
  </div>

  {{-- Theme switcher script --}}
  <script>
    (function () {
      const ROOT = document.documentElement;
      const STORAGE_KEY = 'aurora_theme_pref'; // 'system'|'light'|'dark'
      const btns = document.querySelectorAll('.theme-btn');

      function applyTheme(pref) {
        if (pref === 'system') {
          const isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
          ROOT.classList.toggle('dark', isDark);
        } else {
          ROOT.classList.toggle('dark', pref === 'dark');
        }
        // visual state
        btns.forEach(b => b.classList.remove('ring-2','ring-offset-2','ring-primary-500','scale-105'));
        const active = document.querySelector('.theme-btn[data-theme="'+pref+'"]');
        if (active) active.classList.add('ring-2','ring-offset-2','ring-primary-500','scale-105');
      }

      function save(pref) {
        localStorage.setItem(STORAGE_KEY, pref);
        applyTheme(pref);
      }

      // init
      const stored = localStorage.getItem(STORAGE_KEY) || 'system';
      applyTheme(stored);

      // attach events
      btns.forEach(b => {
        b.addEventListener('click', () => {
          const pref = b.getAttribute('data-theme');
          save(pref);
        });
      });

      // react to system changes when in 'system' mode
      if (window.matchMedia) {
        const mq = window.matchMedia('(prefers-color-scheme: dark)');
        mq.addEventListener ? mq.addEventListener('change', (e) => {
          const pref = localStorage.getItem(STORAGE_KEY) || 'system';
          if (pref === 'system') applyTheme('system');
        }) : mq.addListener((e) => {
          const pref = localStorage.getItem(STORAGE_KEY) || 'system';
          if (pref === 'system') applyTheme('system');
        });
      }

      // Make sure keyboard users can see focus
      document.querySelectorAll('.theme-btn').forEach(b => {
        b.setAttribute('aria-pressed', 'false');
        b.addEventListener('click', () => {
          document.querySelectorAll('.theme-btn').forEach(x => x.setAttribute('aria-pressed','false'));
          b.setAttribute('aria-pressed','true');
        });
      });

    })();
  </script>
</body>
</html>
