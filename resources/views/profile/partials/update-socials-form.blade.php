<section>
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.social_links') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.social_links_subtitle') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('profile.socials.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Primary Socials -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- GitHub -->
            <div class="relative group">
                <x-input-label for="github" :value="__('GitHub')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-800 dark:group-focus-within:text-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </div>
                    <x-text-input id="github" name="github" type="text" class="pl-10 block w-full" :value="old('github', $user->socials->github ?? '')" placeholder="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('github')" />
            </div>

            <!-- LinkedIn -->
            <div class="relative group">
                <x-input-label for="linkedin" :value="__('LinkedIn')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#0A66C2] transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </div>
                    <x-text-input id="linkedin" name="linkedin" type="text" class="pl-10 block w-full" :value="old('linkedin', $user->socials->linkedin ?? '')" placeholder="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
            </div>

            <!-- Twitter / X -->
            <div class="relative group">
                <x-input-label for="twitter" :value="__('Twitter / X')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 dark:group-focus-within:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </div>
                    <x-text-input id="twitter" name="twitter" type="text" class="pl-10 block w-full" :value="old('twitter', $user->socials->twitter ?? '')" placeholder="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
            </div>

            <!-- Website -->
            <div class="relative group">
                <x-input-label for="personal_website" :value="__('Website')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-getmyname-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </div>
                    <x-text-input id="personal_website" name="personal_website" type="url" class="pl-10 block w-full" :value="old('personal_website', $user->socials->personal_website ?? '')" placeholder="https://example.com" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('personal_website')" />
            </div>
        </div>

        <!-- Secondary Socials Toggle Area or just Header -->
        <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-6">{{ __('Community & Design') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Loop for Generic inputs or less common ones -->
                @php
                    $secondarySocials = [
                        ['id' => 'gitlab', 'label' => 'GitLab', 'placeholder' => 'username', 'icon' => 'text-orange-600', 'svg' => '<path d="M23.6 15.1l-3.2-8.3c-.2-.6-.9-.6-1.1 0l-1.3 3.9H6L4.7 6.8c-.2-.6-.9-.6-1.1 0l-3.2 8.3c-.2.5 0 1 .4 1.3l11.2 8.2 11.2-8.2c.4-.3.6-.8.4-1.3z"/>'],
                        ['id' => 'stackoverflow', 'label' => 'Stack Overflow', 'placeholder' => 'user-id', 'icon' => 'text-orange-500', 'svg' => '<path d="M15.7 19.5v-6.2h3.3v9.5H5v-9.5h3.3v6.2h7.4zM7.5 16.3l9.4 2 .4-1.9-9.4-2-.4 1.9zm1.4-4.8l8.7 4.1.8-1.7-8.7-4.1-.8 1.7zm3.1-4.7l7.5 6.1 1.2-1.5-7.5-6.1-1.2 1.5zm5.5-5l-1.4 1.3 5.9 7.3 1.4-1.3-5.9-7.3z"/>'],
                        ['id' => 'npm', 'label' => 'NPM', 'placeholder' => 'username', 'icon' => 'text-red-600', 'svg' => '<path d="M0 7.3v9.3h6.6V10h3.3v6.6h14V7.3H0zm20.6 6.6h-3.3V10h-3.3v4H7.3V10H3.3v4H2.6V9.3h18v4.6z"/>'],
                        ['id' => 'bluesky', 'label' => 'Bluesky', 'placeholder' => 'handle.bsky.social', 'icon' => 'text-blue-500', 'svg' => '<path d="M12 10.8c-1.6-1.9-3.3-3.1-6-3.1-2.9 0-4.7 1.9-4.7 4.7 0 3.3 2.8 5.6 5.3 5.6 1.3 0 2.5-.5 3.5-1.3l-2.4-2.4c-.6.4-1.1.5-1.1.5-1.1 0-1.6-.9-1.6-1.6 0-1.6 2.1-2.4 2.8-2.7 1.2-.4 2.8.2 4.2 1.8 1.4-1.6 3-2.2 4.2-1.8.7.3 2.8 1.1 2.8 2.7 0 .7-.5 1.6-1.6 1.6 0 0-.5-.1-1.1-.5l-2.4 2.4c1 .8 2.2 1.3 3.5 1.3 2.5 0 5.3-2.3 5.3-5.6 0-2.8-1.8-4.7-4.7-4.7-2.7 0-4.4 1.2-6 3.1z"/>'],
                        ['id' => 'dev_to', 'label' => 'Dev.to', 'placeholder' => 'username', 'icon' => 'text-gray-800 dark:text-white', 'svg' => '<path d="M7.1 12.3v-4h1.7v3h.6v-3h1.7v4H7.1zm5.2 0v-4h2.9v.9h-1.9v.6h1.8v.9H13.3v.7h2v.9h-3zm5.7-4v4h3.1v-.9h-2.1v-.6h2v-.9h-2v-.7h2.1v-.9H18zM0 0h24v24H0V0zm2.7 2.7v18.6h18.6V2.7H2.7z"/>'],
                        ['id' => 'dribbble', 'label' => 'Dribbble', 'placeholder' => 'username', 'icon' => 'text-pink-500', 'svg' => '<path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.125-9.673c-.22-.057-3.924-1.242-7.91 1.696.533 1.353.96 2.773 1.25 4.218 3.535-1.745 5.86-4.71 6.66-5.914zm-4.32 7.02c-.31-1.44-.766-2.865-1.32-4.225-3.326 2.584-6.39 3.123-6.936 3.187.35 2.81 2.25 5.166 4.79 6.22 1.096-.285 2.585-1.693 3.466-5.182zm-9.52 5.09c.477-.044 3.328-.5 6.47-2.924-2.228-3.94-5.263-6.666-6.425-7.63.156 3.45-1.896 6.55-4.887 8.04 1.493.89 3.23 1.413 5.087 1.413-.083.33.056.74.056.74-.085-.29.098.36.098.36zM2.28 15.618c2.614-1.397 4.545-4.04 4.86-7.394C6.544 8 2.51 8.292 2.112 8.337c.05 2.583.992 4.956 2.556 6.848-.795.143 1.765.316-2.387.433zM3.483 6.378c.51-.05 3.935-.34 6.77.168.196-.547.41-1.127.635-1.728-3.085-1.31-6.195-1.275-6.52-1.267 1.815 1.576 4.264 2.656 6.993 2.915.228.61.437 1.18.618 1.705 1.206.945 4.58 3.738 6.942 7.82.268-.507.502-1.03.703-1.575-3.703-2.174-5.16-5.552-5.32-5.945C16.96 7.6 19.332 7.61 19.392 7.61c-1.37-3.153-4.318-5.462-7.85-5.632-.236.42-1.516 3.49-5.16 5.564z"/>'],
                        ['id' => 'figma', 'label' => 'Figma', 'placeholder' => '@username', 'icon' => 'text-purple-500', 'svg' => '<path d="M7.3 24c-2 0-3.6-1.6-3.6-3.6S5.3 16.7 7.3 16.7h3.6V24H7.3zM7.3 9.3h3.6v7.3H7.3C5.3 16.7 3.6 15 3.6 13s1.7-3.7 3.7-3.7zm3.6-9.3H7.3C5.3 0 3.6 1.6 3.6 3.6S5.3 7.3 7.3 7.3h3.6V0zm3.6 7.3h3.6c2 0 3.6-1.6 3.6-3.6S16.5 0 14.5 0h-3.6v7.3zm0 7.3V7.3h3.6c2 0 3.6 1.6 3.6 3.6s-1.6 3.6-3.6 3.6h-3.6z"/>'],
                        ['id' => 'codepen', 'label' => 'CodePen', 'placeholder' => 'username', 'icon' => 'text-gray-800 dark:text-white', 'svg' => '<path d="M24 8.2V16l-12 8-12-8V8.2L0 8l12-8 12 8 .2.2zm-12-5L4.3 8.3 12 13.4l7.7-5.1L12 3.2zm0 13.6l-7.7-5.1L2.2 13 12 19.5l9.8-6.5-2.1-1.4-7.7 5.1zm-9.3-5.2l2.1 1.4L2.6 10l2.2 2.6zm18.6 0l2.1-1.4 2.2-2.6-2.2-2.6-2.1 1.4z"/>'],
                        ['id' => 'instagram', 'label' => 'Instagram', 'placeholder' => 'username', 'icon' => 'text-pink-600', 'svg' => '<path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 2 .3 2.7.7.7.3 1.3.7 1.9 1.3.6.6 1 1.3 1.3 1.9.4.7.6 1.5.7 2.7.1 1.2.1 1.6.1 4.8 0 3.2 0 3.6-.1 4.8-.1 1.2-.3 2-.7 2.7-.3.7-.7 1.3-1.3 1.9-.6.6-1.3 1-1.9 1.3-.7.4-1.5.6-2.7.7-1.2.1-1.6.1-4.8.1-3.2 0-3.6 0-4.8-.1-1.2-.1-2-.3-2.7-.7-.7-.3-1.3-.7-1.9-1.3-.6-.6-1-1.3-1.3-1.9-.4-.7-.6-1.5-.7-2.7-.1-1.2-.1-1.6-.1-4.8 0-3.2 0-3.6.1-4.8.1-1.2.3-2 .7-2.7.3-.7.7-1.3 1.3-1.9.6-.6 1.3-1 1.9-1.3.7-.4 1.5-.6 2.7-.7 1.2-.1 1.6-.1 4.8-.1zm0-2.2C8.7 0 8.3 0 7.1.1c-1.3.1-2.2.3-3 .6-.8.3-1.6.7-2.3 1.4C1.1 2.8.7 3.6.4 4.4c-.3.8-.5 1.7-.6 3C-.2 8.7-.2 9.1-.2 12s0 3.3.1 4.6c.1 1.3.3 2.2.6 3 .3.8.7 1.6 1.4 2.3.7.7 1.5 1.1 2.3 1.4.8.3 1.7.5 3 .6 1.3.1 1.7.1 4.9.1 3.2 0 3.6 0 4.9-.1 1.3-.1 2.2-.3 3-.6.8-.3 1.6-.7 2.3-1.4.7-.7 1.1-1.5 1.4-2.3.3-.8.5-1.7.6-3 .1-1.3.1-1.7.1-4.9s0-3.6-.1-4.6c-.1-1.3-.3-2.2-.6-3-.3-.8-.7-1.6-1.4-2.3-.7-.7-1.5-1.1-2.3-1.4-.8-.3-1.7-.5-3-.6-1.3-.1-1.7-.1-4.9-.1zM12 5.8c-3.4 0-6.2 2.8-6.2 6.2s2.8 6.2 6.2 6.2 6.2-2.8 6.2-6.2-2.8-6.2-6.2-6.2zm0 10.2c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4zm6.4-9c-.6 0-1.1.5-1.1 1.1s.5 1.1 1.1 1.1 1.1-.5 1.1-1.1-.5-1.1-1.1-1.1z"/>'],
                        ['id' => 'youtube_url', 'label' => 'YouTube', 'placeholder' => 'https://youtube.com/@handle', 'icon' => 'text-red-600', 'svg' => '<path d="M23.5 6.2s-.2-1.7-1-2.4c-.9-1-1.9-1-2.3-1C17 2.6 12 2.6 12 2.6s-5 0-8.1.2c-.5 0-1.5 0-2.3 1-.7.7-1 2.4-1 2.4S.4 7.9.4 9.7v1.7c0 1.8.2 3.5.2 3.5s.2 1.7 1 2.4c.9 1 1.9 1 2.3 1 3.1.2 8.1.2 8.1.2s5 0 8.1-.2c.5 0 1.5 0 2.3-1 .7-.7 1-2.4 1-2.4s.2-1.7.2-3.5V9.7c0-1.8-.2-3.5-.2-3.5zM9.5 15.5V8.5l6.5 3.5-6.5 3.5z"/>'],
                    ];
                @endphp

                @foreach ($secondarySocials as $social)
                    <div class="relative group">
                        <x-input-label :for="$social['id']" :value="__('profile.' . $social['id'] . '_username', ['default' => $social['label']])" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:{{ $social['icon'] }} transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">{!! $social['svg'] !!}</svg>
                            </div>
                            <x-text-input 
                                :id="$social['id']" 
                                :name="$social['id']" 
                                type="text" 
                                class="pl-10 block w-full" 
                                :value="old($social['id'], $user->socials->{$social['id']} ?? '')" 
                                :placeholder="$social['placeholder']" 
                            />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get($social['id'])" />
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>
            @if (session('status') === 'socials-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('profile.saved') }}
                </div>
            @endif
        </div>
    </form>
</section>