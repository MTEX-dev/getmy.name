<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.about_me_title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.about_me_subtitle') }}
        </p>
    </header>

    <form
        method="post"
        action="{{ route('profile.about-me.update') }}"
        class="mt-6 space-y-6"
    >
        @csrf
        @method('patch')

        <div>
            <x-input-label for="about_me" :value="__('profile.about_me')" />
            <x-textarea-input
                id="about_me"
                name="about_me"
                class="mt-1 block w-full"
                :value="old('about_me', $user->about_me ?? '')"
                rows="5"
            />
            <x-input-error class="mt-2" :messages="$errors->get('about_me')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'about-me-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('profile.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>