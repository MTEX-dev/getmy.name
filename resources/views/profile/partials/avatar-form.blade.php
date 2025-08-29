<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.avatar_subtitle') }}
        </p>
    </header>

    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:gap-6">
        <!-- Avatar Preview -->
        <div class="w-24 h-24">
            <img 
                src="{{ auth()->user()->avatar() }}" 
                alt="Avatar" 
                class="h-24 w-24 rounded-full border border-gray-300 dark:border-gray-700 shadow-sm object-cover"
            />
        </div>

        <!-- Upload & Action Buttons -->
        <form 
            method="post" 
            action="{{ route('profile.avatar.update') }}" 
            class="mt-4 sm:mt-0 flex-1 space-y-4" 
            enctype="multipart/form-data"
        >
            @csrf
            @method('patch')

            <!-- File Input (using component) -->
            <div>
                <x-input-label for="avatar" :value="__('profile.avatar_upload')" />

                <x-file-input 
                    id="avatar"
                    name="avatar"
                    accept="image/*"
                />

                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4">
                <!-- Save Button -->
                <x-primary-button>{{ __('profile.save') }}</x-primary-button>

                <!-- Remove Button -->
                @if (auth()->user()->avatar_path)
                    <form 
                        method="post" 
                        action="{{ route('profile.avatar.destroy') }}" 
                        class="inline"
                    >
                        @csrf
                        @method('delete')
                        <x-danger-button>{{ __('profile.remove_avatar') }}</x-danger-button>
                    </form>
                @endif

                <!-- Saved Message -->
                @if (session('status') === 'avatar-updated')
                    <p 
                        x-data="{ show: true }" 
                        x-show="show" 
                        x-transition 
                        x-init="setTimeout(() => show = false, 2000)" 
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
</section>
