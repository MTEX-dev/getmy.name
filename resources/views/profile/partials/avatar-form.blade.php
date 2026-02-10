<section>
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.avatar') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.avatar_subtitle') }}
            </p>
        </div>
    </header>

    <div 
        x-data="{ 
            photoPreview: null,
            fileName: null,
            handleFileChange(e) {
                const file = e.target.files[0];
                if (!file) return;
                this.fileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }" 
        class="mt-8 flex flex-col lg:flex-row items-start gap-12"
    >
        <!-- Preview Column -->
        <div class="flex flex-col items-center gap-6 flex-shrink-0 mx-auto lg:mx-0">
            <div class="relative group">
                <div class="w-48 h-48 rounded-full ring-4 ring-white dark:ring-gray-800 shadow-xl overflow-hidden bg-gray-100 dark:bg-gray-900 relative">
                    <!-- Loading Skeleton / Default -->
                    <template x-if="!photoPreview">
                        <img 
                            src="{{ auth()->user()->avatar() }}" 
                            alt="{{ auth()->user()->name }}" 
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                    </template>
                    <!-- New Preview -->
                    <template x-if="photoPreview">
                        <div class="relative h-full w-full">
                            <img 
                                :src="photoPreview" 
                                class="h-full w-full object-cover"
                            />
                            <!-- Uploading Indicator (Visual only until saved) -->
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center backdrop-blur-[1px]">
                                <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </div>
                        </div>
                    </template>
                </div>

                @if (auth()->user()->avatar_path)
                    <form 
                        method="post" 
                        action="{{ route('profile.avatar.destroy') }}" 
                        class="absolute bottom-2 right-2 z-10"
                        onsubmit="return confirm('{{ __('Are you sure you want to delete your avatar?') }}');"
                    >
                        @csrf
                        @method('delete')
                        <button 
                            type="submit" 
                            class="flex items-center justify-center w-10 h-10 bg-white dark:bg-gray-800 text-rose-500 rounded-full shadow-lg border border-gray-100 dark:border-gray-700 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-all hover:scale-110 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                            title="{{ __('profile.remove_avatar') }}"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>
            
            <div x-show="photoPreview" class="text-center" x-transition>
                <p class="text-xs font-bold uppercase tracking-wider text-getmyname-600 dark:text-getmyname-400 mb-1">
                    {{ __('Preview Mode') }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="fileName"></p>
            </div>
        </div>

        <!-- Form Column -->
        <form 
            method="post" 
            action="{{ route('profile.avatar.update') }}" 
            class="flex-1 w-full flex flex-col gap-6" 
            enctype="multipart/form-data"
        >
            @csrf
            @method('patch')

            <div class="relative group">
                <label 
                    for="avatar" 
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-3xl cursor-pointer bg-gray-50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-800 transition-all hover:border-getmyname-400 dark:hover:border-getmyname-500 group-hover:shadow-lg"
                >
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                        <div class="mb-4 p-4 rounded-full bg-white dark:bg-gray-800 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                        </div>
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ __('Click to upload') }} <span class="font-normal text-gray-500">{{ __('or drag and drop') }}</span>
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            SVG, PNG, JPG or GIF (MAX. 2MB)
                        </p>
                    </div>
                    <input 
                        type="file" 
                        id="avatar" 
                        name="avatar" 
                        accept="image/*"
                        @change="handleFileChange"
                        class="hidden"
                    />
                </label>
                <x-input-error class="mt-3" :messages="$errors->get('avatar')" />
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <x-primary-button class="px-8 py-3 text-base">
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