<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.avatar_subtitle') }}
        </p>
    </header>

    <div 
        x-data="{ 
            photoPreview: null,
            handleFileChange(e) {
                const file = e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }" 
        class="mt-8 flex flex-col md:flex-row items-center md:items-start gap-10"
    >
        <div class="flex flex-col items-center gap-4">
            <div class="relative">
                <div class="w-40 h-40 md:w-48 md:h-48 rounded-full ring-4 ring-gray-100 dark:ring-gray-800 overflow-hidden shadow-inner bg-gray-50 dark:bg-gray-900">
                    <template x-if="!photoPreview">
                        <img 
                            src="{{ auth()->user()->avatar() }}" 
                            alt="{{ auth()->user()->name }}" 
                            class="h-full w-full object-cover transition-opacity duration-300"
                        />
                    </template>
                    <template x-if="photoPreview">
                        <img 
                            :src="photoPreview" 
                            class="h-full w-full object-cover animate-pulse-once"
                        />
                    </template>
                </div>

                @if (auth()->user()->avatar_path)
                    <form 
                        method="post" 
                        action="{{ route('profile.avatar.destroy') }}" 
                        class="absolute bottom-2 right-2"
                    >
                        @csrf
                        @method('delete')
                        <button 
                            type="submit" 
                            class="flex items-center justify-center w-10 h-10 bg-white dark:bg-gray-700 text-red-500 rounded-full shadow-xl border border-gray-200 dark:border-gray-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all hover:scale-110"
                            title="{{ __('profile.remove_avatar') }}"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>
            
            <p x-show="photoPreview" class="text-xs font-medium text-getmyname-600 dark:text-getmyname-400 animate-bounce">
                {{ __('profile.preview_mode') ?? 'Previewing new avatar' }}
            </p>
        </div>

        <form 
            method="post" 
            action="{{ route('profile.avatar.update') }}" 
            class="flex-1 w-full flex flex-col gap-6" 
            enctype="multipart/form-data"
        >
            @csrf
            @method('patch')

            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 transition-colors hover:border-getmyname-400">
                <x-input-label for="avatar" class="text-base font-semibold mb-2" :value="__('profile.upload_new_image')" />
                
                <input 
                    type="file" 
                    id="avatar" 
                    name="avatar" 
                    accept="image/*"
                    @change="handleFileChange"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2.5 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-getmyname-50 file:text-getmyname-700
                        hover:file:bg-getmyname-100
                        dark:file:bg-getmyname-900/30 dark:file:text-getmyname-400
                        cursor:pointer"
                />

                <div class="mt-4 flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        JPG, PNG, GIF
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Max 2MB
                    </span>
                </div>

                <x-input-error class="mt-3" :messages="$errors->get('avatar')" />
            </div>

            <div class="flex items-center justify-center md:justify-start gap-4">
                <x-primary-button class="px-8">
                    {{ __('profile.save') ?? __('profile.save') }}
                </x-primary-button>

                @if (session('status') === 'avatar-updated')
                    <div 
                        x-data="{ show: true }" 
                        x-show="show" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-init="setTimeout(() => show = false, 3000)" 
                        class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400 font-medium"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('profile.saved') }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>