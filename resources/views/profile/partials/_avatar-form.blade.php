<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.avatar_subtitle') }}
        </p>
    </header>

    <div class="mt-6 flex flex-col md:flex-row items-start gap-8">
        <div class="relative group">
            <div class="w-32 h-32 md:w-40 md:h-40">
                <img 
                    src="{{ auth()->user()->avatar() }}" 
                    alt="Avatar" 
                    class="h-full w-full rounded-2xl border-2 border-gray-200 dark:border-gray-700 shadow-sm object-cover"
                />
            </div>
            
            @if (auth()->user()->avatar_path)
                <form 
                    method="post" 
                    action="{{ route('profile.avatar.destroy') }}" 
                    class="absolute -top-2 -right-2"
                >
                    @csrf
                    @method('delete')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-lg transition-transform hover:scale-110" title="{{ __('profile.remove_avatar') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>

        <form 
            method="post" 
            action="{{ route('profile.avatar.update') }}" 
            class="flex-1 w-full space-y-6" 
            enctype="multipart/form-data"
        >
            @csrf
            @method('patch')

            <div class="max-w-xl">
                <x-input-label for="avatar" :value="__('profile.avatar_upload')" />
                
                <div class="mt-2">
                    <x-file-input 
                        id="avatar"
                        name="avatar"
                        accept="image/*"
                        class="w-full"
                    />
                </div>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    {{ __('profile.avatar_hint') ?? 'PNG, JPG or GIF. Max 2MB.' }}
                </p>

                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('profile.save') }}</x-primary-button>

                @if (session('status') === 'avatar-updated')
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
    </div>
</section>