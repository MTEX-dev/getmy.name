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

            <div>
                <x-input-label for="avatar" :value="__('profile.avatar_upload')" />
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/*"
                    class="block w-full text-sm text-gray-900 dark:text-gray-300
                           border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer
                           bg-gray-50 dark:bg-gray-700
                           focus:outline-none focus:ring-2 focus:ring-violet-300 dark:focus:ring-violet-600
                           file:py-2 file:px-4 file:rounded-md file:border-0 
                           file:text-sm file:font-semibold
                           file:bg-violet-100 file:text-violet-800 hover:file:bg-violet-200
                           dark:file:bg-violet-800 dark:file:text-violet-200 dark:hover:file:bg-violet-700"
                />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>

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

                <!-- Saved message -->
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
