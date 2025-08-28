<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Social Links') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your social media and personal website links.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.socials.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="github" :value="__('GitHub Username') . ' (' . __('Optional') . ')'" />
            <x-text-input id="github" name="github" type="text" class="mt-1 block w-full" :value="old('github', $user->socials->github ?? '')" autocomplete="github" placeholder="e.g., yourgithubusername" />
            <x-input-error class="mt-2" :messages="$errors->get('github')" />
        </div>

        <div>
            <x-input-label for="linkedin" :value="__('LinkedIn Username') . ' (' . __('Optional') . ')'" />
            <x-text-input id="linkedin" name="linkedin" type="text" class="mt-1 block w-full" :value="old('linkedin', $user->socials->linkedin ?? '')" autocomplete="linkedin" placeholder="e.g., yourlinkedinusername" />
            <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
        </div>

        <div>
            <x-input-label for="twitter" :value="__('Twitter Username') . ' (' . __('Optional') . ')'" />
            <x-text-input id="twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $user->socials->twitter ?? '')" autocomplete="twitter" placeholder="e.g., yourtwitterhandle" />
            <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
        </div>

        <div>
            <x-input-label for="personal_website" :value="__('Personal Website URL') . ' (' . __('Optional') . ')'" />
            <x-text-input id="personal_website" name="personal_website" type="url" class="mt-1 block w-full" :value="old('personal_website', $user->socials->personal_website ?? '')" autocomplete="personal_website" placeholder="e.g., https://yourwebsite.com" />
            <x-input-error class="mt-2" :messages="$errors->get('personal_website')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'socials-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>