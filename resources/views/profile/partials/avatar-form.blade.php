<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.avatar_subtitle') }}
        </p>
    </header>

    <img src="{{ auth()->user()->avatar() }}" alt="Avatar" class="mt-4 h-24 w-24 rounded-full" />

    <form method="post" action="{{ route('profile.avatar.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" :value="__('profile.avatar_upload')" />
            <input
                id="avatar"
                name="avatar"
                type="file"
                class="form-input file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-900 dark:file:text-violet-300 dark:hover:file:bg-violet-800
                       block w-full text-sm text-gray-900 dark:text-gray-400
                       border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer
                       bg-gray-50 dark:bg-gray-700
                       focus:outline-none focus:ring focus:ring-violet-200 dark:focus:ring-violet-700"
            />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'avatar-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

    @if (auth()->user()->avatar_path)
        <form method="post" action="{{ route('profile.avatar.destroy') }}" class="mt-6">
            @csrf
            @method('delete')
            <x-danger-button>{{ __('profile.remove_avatar') }}</x-danger-button>
        </form>
    @endif
</section>