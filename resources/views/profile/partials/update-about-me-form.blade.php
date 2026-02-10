<section x-data="{ count: 0 }" x-init="count = $refs.bioInput.value.length">
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.about_me_title') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.about_me_subtitle') }}
            </p>
        </div>
    </header>

    <form
        method="post"
        action="{{ route('profile.about-me.update') }}"
        class="mt-8 space-y-6"
    >
        @csrf
        @method('patch')

        <div class="max-w-4xl">
            <div class="flex items-center justify-between mb-2">
                <x-input-label for="about_me" :value="__('profile.about_me')" class="text-base font-semibold" />
                <span class="text-xs text-gray-400 dark:text-gray-500 font-mono" x-text="count + ' chars'"></span>
            </div>
            
            <div class="relative group">
                <x-textarea-input
                    x-ref="bioInput"
                    @input="count = $el.value.length"
                    id="about_me"
                    name="about_me"
                    class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 focus:ring-getmyname-500 focus:border-getmyname-500 rounded-xl transition-shadow shadow-sm group-hover:border-gray-300 dark:group-hover:border-gray-600"
                    :value="old('about_me', $user->about_me ?? '')"
                    rows="10"
                    placeholder="{{ __('profile.about_me_placeholder') ?? 'Tell the world about yourself...' }}"
                />
                
                <!-- Helper / Tip -->
                <div class="absolute bottom-3 right-3 flex items-center gap-1 text-xs text-gray-400 pointer-events-none opacity-50">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    Markdown Supported
                </div>
            </div>
            
            <x-input-error class="mt-2" :messages="$errors->get('about_me')" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button class="px-6 py-2.5">
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