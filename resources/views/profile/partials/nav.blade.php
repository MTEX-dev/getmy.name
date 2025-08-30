<div class="flex space-x-4">
    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
        {{ __('profile.profile') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.skills')" :active="request()->routeIs('profile.skills')">
        {{ __('Skills') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.projects')" :active="request()->routeIs('profile.projects')">
        {{ __('Projects') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.experiences')" :active="request()->routeIs('profile.experiences')">
        {{ __('Experiences') }}
    </x-nav-link>
    <x-nav-link :href="route('profile.socials')" :active="request()->routeIs('profile.socials')">
        {{ __('Socials') }}
    </x-nav-link>
</div>
