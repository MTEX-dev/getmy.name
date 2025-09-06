<div class="flex space-x-4">
    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
        {{ __('profile.profile') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.about-me')" :active="request()->routeIs('profile.about-me')">
        {{ __('profile.about_me_title') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.skills')" :active="request()->routeIs('profile.skills')">
        {{ __('profile.skills') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.projects')" :active="request()->routeIs('profile.projects')">
        {{ __('profile.projects.title') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.experiences')" :active="request()->routeIs('profile.experiences')">
        {{ __('profile.experiences.title') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.education')" :active="request()->routeIs('profile.education')">
        {{ __('profile.education') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.socials')" :active="request()->routeIs('profile.socials')">
        {{ __('profile.socials.title') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.preview')" :active="request()->routeIs('profile.preview')">
        {{ __('profile.preview.title') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.api-requests.index')" :active="request()->routeIs('profile.api-requests.index')">
        {{ __('profile.api_requests.title') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.api-tokens.index')" :active="request()->routeIs('profile.api-tokens.index')">
        {{ __('API Tokens') }}
    </x-nav-link>
</div>