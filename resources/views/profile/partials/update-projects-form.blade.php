<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('profile.projects') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.projects_subtitle') }}
                </p>
            </div>
        </div>
    </header>

    <div class="mt-8 space-y-6">
        @if ($user->projects->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($user->projects as $project)
                    <div class="group relative flex flex-col bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden transition-all hover:shadow-md hover:border-getmyname-300 dark:hover:border-getmyname-700">
                        <!-- Image Area -->
                        <div class="aspect-video w-full bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                            @if ($project->image)
                                <img 
                                    src="{{ Storage::url($project->image) }}" 
                                    alt="{{ $project->title }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                >
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Action Buttons Overlay -->
                            <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('profile.projects.edit', $project) }}" class="p-1.5 bg-white/90 dark:bg-gray-800/90 text-blue-600 rounded-lg shadow-sm hover:text-blue-700 backdrop-blur-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <form method="post" action="{{ route('profile.projects.destroy', $project) }}">
                                    @csrf
                                    @method('delete')
                                    <button 
                                        type="submit" 
                                        class="p-1.5 bg-white/90 dark:bg-gray-800/90 text-red-600 rounded-lg shadow-sm hover:text-red-700 backdrop-blur-sm"
                                        onclick="return confirm('{{ __('profile.confirm_delete_project') }}')"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-4 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 line-clamp-1">{{ $project->title }}</h3>
                                @if ($project->url)
                                    <a href="{{ $project->url }}" target="_blank" class="text-gray-400 hover:text-getmyname-500 transition-colors" title="{{ $project->url }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>
                                @endif
                            </div>
                            
                            @if ($project->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-2 flex-1">
                                    {{ $project->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-2xl text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 dark:bg-gray-900 mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('profile.no_projects_added') }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ __('profile.projects_subtitle') }}</p>
            </div>
        @endif
    </div>

    <div class="mt-10 pt-10 border-t border-gray-100 dark:border-gray-800">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('profile.add_new_project') ?? 'Add New Project' }}
        </h3>

        <form method="post" action="{{ route('profile.projects.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="project_title" :value="__('profile.new_project_title')" />
                    <x-text-input id="project_title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" autocomplete="off" placeholder="My Awesome App" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div>
                    <x-input-label for="project_url" :value="__('profile.project_url') . ' (' . __('profile.optional') . ')'" />
                    <x-text-input id="project_url" name="url" type="url" class="mt-1 block w-full" :value="old('url')" autocomplete="off" placeholder="https://example.com" />
                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="project_description" :value="__('profile.project_description') . ' (' . __('profile.optional') . ')'" />
                    <x-text-input id="project_description" name="description" type="text" class="mt-1 block w-full" :value="old('description')" autocomplete="off" placeholder="{{ __('profile.project_description_placeholder') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="project_image" :value="__('profile.project_image') . ' (' . __('profile.optional') . ')'" />
                    <x-file-input id="project_image" name="image" class="mt-1 block w-full" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG or WEBP. Recommended size: 1200x630px.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('profile.add_project') }}</x-primary-button>

                @if (session('status') === 'project-added')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('profile.project_added_successfully') }}
                    </div>
                @endif
                @if (session('status') === 'project-deleted')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        {{ __('profile.project_removed_successfully') }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>