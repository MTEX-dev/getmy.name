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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div>
                <x-input-label for="github" :value="__('profile.github_username') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="github" name="github" type="text" class="mt-1 block w-full" :value="old('github', $user->socials->github ?? '')" placeholder="{{ __('profile.github_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('github')" />
            </div>

            <div>
                <x-input-label for="linkedin" :value="__('profile.linkedin_username') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="linkedin" name="linkedin" type="text" class="mt-1 block w-full" :value="old('linkedin', $user->socials->linkedin ?? '')" placeholder="{{ __('profile.linkedin_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
            </div>

            <div>
                <x-input-label for="twitter" :value="__('profile.twitter_username') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $user->socials->twitter ?? '')" placeholder="{{ __('profile.twitter_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
            </div>

            <div>
                <x-input-label for="personal_website" :value="__('profile.personal_website_url') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="personal_website" name="personal_website" type="url" class="mt-1 block w-full" :value="old('personal_website', $user->socials->personal_website ?? '')" placeholder="{{ __('profile.personal_website_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('personal_website')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 border-t border-gray-100 dark:border-gray-800 pt-6">
            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="gitlab" :value="__('profile.gitlab_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="gitlab" name="gitlab" type="text" class="mt-1 block w-full" :value="old('gitlab', $user->socials->gitlab ?? '')" placeholder="{{ __('profile.gitlab_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('gitlab')" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="stackoverflow" :value="__('profile.stackoverflow_id') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="stackoverflow" name="stackoverflow" type="text" class="mt-1 block w-full" :value="old('stackoverflow', $user->socials->stackoverflow ?? '')" placeholder="{{ __('profile.stackoverflow_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('stackoverflow')" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="npm" :value="__('profile.npm_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="npm" name="npm" type="text" class="mt-1 block w-full" :value="old('npm', $user->socials->npm ?? '')" placeholder="{{ __('profile.npm_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('npm')" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="bluesky" :value="__('profile.bluesky_handle') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="bluesky" name="bluesky" type="text" class="mt-1 block w-full" :value="old('bluesky', $user->socials->bluesky ?? '')" placeholder="{{ __('profile.bluesky_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('bluesky')" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="dev_to" :value="__('profile.dev_to_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="dev_to" name="dev_to" type="text" class="mt-1 block w-full" :value="old('dev_to', $user->socials->dev_to ?? '')" placeholder="{{ __('profile.dev_to_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('dev_to')" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="hashnode" :value="__('profile.hashnode_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="hashnode" name="hashnode" type="text" class="mt-1 block w-full" :value="old('hashnode', $user->socials->hashnode ?? '')" placeholder="{{ __('profile.hashnode_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('hashnode')" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="product_hunt" :value="__('profile.product_hunt_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="product_hunt" name="product_hunt" type="text" class="mt-1 block w-full" :value="old('product_hunt', $user->socials->product_hunt ?? '')" placeholder="{{ __('profile.product_hunt_placeholder') }}" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="polywork" :value="__('profile.polywork_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="polywork" name="polywork" type="text" class="mt-1 block w-full" :value="old('polywork', $user->socials->polywork ?? '')" placeholder="{{ __('profile.polywork_placeholder') }}" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="dribbble" :value="__('profile.dribbble_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="dribbble" name="dribbble" type="text" class="mt-1 block w-full" :value="old('dribbble', $user->socials->dribbble ?? '')" placeholder="{{ __('profile.dribbble_placeholder') }}" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="figma" :value="__('profile.figma_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="figma" name="figma" type="text" class="mt-1 block w-full" :value="old('figma', $user->socials->figma ?? '')" placeholder="{{ __('profile.figma_placeholder') }}" />
            </div>

            <!--div>
                <x-input-label for="modrinth" :value="__('profile.modrinth_username')" />
                <x-text-input id="modrinth" name="modrinth" type="text" class="mt-1 block w-full" :value="old('modrinth', $user->socials->modrinth ?? '')" placeholder="{{ __('profile.modrinth_placeholder') }}" />
            </div-->

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="codepen" :value="__('profile.codepen_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="codepen" name="codepen" type="text" class="mt-1 block w-full" :value="old('codepen', $user->socials->codepen ?? '')" placeholder="{{ __('profile.codepen_placeholder') }}" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="instagram" :value="__('profile.instagram_username') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="instagram" name="instagram" type="text" class="mt-1 block w-full" :value="old('instagram', $user->socials->instagram ?? '')" placeholder="{{ __('profile.instagram_placeholder') }}" />
            </div>

            <div>
                <div class="flex items-center gap-x-2">
                    <x-input-label for="youtube_url" :value="__('profile.youtube_url') . ' (' . __('profile.optional') . ')'" />
                    @include('components.badges.new')
                </div>
                <x-text-input id="youtube_url" name="youtube_url" type="url" class="mt-1 block w-full" :value="old('youtube_url', $user->socials->youtube_url ?? '')" placeholder="{{ __('profile.youtube_placeholder') }}" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>
            @if (session('status') === 'socials-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>