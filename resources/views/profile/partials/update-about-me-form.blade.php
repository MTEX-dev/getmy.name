<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('profile.about_me_title') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.about_me_subtitle') }}
                </p>
            </div>
        </div>
    </header>

    <form
        method="post"
        action="{{ route('profile.about-me.update') }}"
        class="mt-6 space-y-6"
    >
        @csrf
        @method('patch')

        <div class="max-w-4xl">
            <x-input-label for="about_me" :value="__('profile.about_me')" class="text-base font-medium" />
            
            <div class="mt-2">
                <x-textarea-input
                    id="about_me"
                    name="about_me"
                    class="block w-full border-gray-200 dark:border-gray-800 focus:ring-getmyname-500 focus:border-getmyname-500 rounded-xl"
                    :value="old('about_me', $user->about_me ?? '')"
                    rows="8"
                    placeholder="{{ __('profile.about_me_placeholder') ?? 'Tell the world about yourself...' }}"
                />
            </div>
            
            <div class="mt-2 flex items-center justify-between">
                <!--p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('profile.markdown_supported') ?? 'Markdown is supported.' }}
                </p-->
                <x-input-error :messages="$errors->get('about_me')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-8">
                {{ __('profile.save') }}
            </x-primary-button>

            @if (session('status') === 'about-me-updated')
                <div 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-transition 
                    x-init="setTimeout(() => show = false, 2000)" 
                    class="flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('profile.saved') }}
                </div>
            @endif
        </div>
    </form>
</section>