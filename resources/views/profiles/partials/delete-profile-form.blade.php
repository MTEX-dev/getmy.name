<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Portfolio Profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your portfolio profile is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your portfolio profile.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-profile-deletion')"
    >{{ __('Delete Portfolio Profile') }}</x-danger-button>

    <x-modal name="confirm-profile-deletion" :show="$errors->profileDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profiles.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your portfolio profile?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your portfolio profile is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your portfolio profile.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->profileDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Profile') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>