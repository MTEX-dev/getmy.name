<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.social_links') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.social_links_subtitle') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.socials.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="github" :value="__('profile.github_username') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="github" name="github" type="text" class="mt-1 block w-full" :value="old('github', $user->socials->github ?? '')" autocomplete="github" placeholder="{{ __('profile.github_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('github')" />
        </div>

        <div>
            <x-input-label for="linkedin" :value="__('profile.linkedin_username') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="linkedin" name="linkedin" type="text" class="mt-1 block w-full" :value="old('linkedin', $user->socials->linkedin ?? '')" autocomplete="linkedin" placeholder="{{ __('profile.linkedin_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
        </div>

        <div>
            <x-input-label for="twitter" :value="__('profile.twitter_username') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $user->socials->twitter ?? '')" autocomplete="twitter" placeholder="{{ __('profile.twitter_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
        </div>

        <div>
            <x-input-label for="personal_website" :value="__('profile.personal_website_url') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="personal_website" name="personal_website" type="url" class="mt-1 block w-full" :value="old('personal_website', $user->socials->personal_website ?? '')" autocomplete="personal_website" placeholder="{{ __('profile.personal_website_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('personal_website')" />
        </div>

        <div>
            <div class="flex items-center gap-x-2">
                <x-input-label for="codepen" :value="__('profile.codepen_username') . ' (' . __('profile.optional') . ')'" />
                @include('components.badges.new')
            </div>
            <x-text-input id="codepen" name="codepen" type="text" class="mt-1 block w-full" :value="old('codepen', $user->socials->codepen ?? '')" autocomplete="codepen" placeholder="{{ __('profile.codepen_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('codepen')" />
        </div>

        <div>
            <div class="flex items-center gap-x-2">
                <x-input-label for="instagram" :value="__('profile.instagram_username') . ' (' . __('profile.optional') . ')'" />
                @include('components.badges.new')
            </div>
            <x-text-input id="instagram" name="instagram" type="text" class="mt-1 block w-full" :value="old('instagram', $user->socials->instagram ?? '')" autocomplete="instagram" placeholder="{{ __('profile.instagram_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('instagram')" />
        </div>

        <div>
            <div class="flex items-center gap-x-2">
                <x-input-label for="youtube_url" :value="__('profile.youtube_url') . ' (' . __('profile.optional') . ')'" />
                @include('components.badges.new')
            </div>
            <x-text-input id="youtube_url" name="youtube_url" type="url" class="mt-1 block w-full" :value="old('youtube_url', $user->socials->youtube_url ?? '')" autocomplete="youtube_url" placeholder="{{ __('profile.youtube_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('youtube_url')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'socials-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('profile.saved') }}</p>
            @endif
        </div>
    </form>
</section>