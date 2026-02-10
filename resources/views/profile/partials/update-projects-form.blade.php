<section>
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.projects') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.projects_subtitle') }}
            </p>
        </div>
    </header>

    <div class="mb-10">
        @if ($user->projects->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($user->projects as $project)
                    <div class="group relative flex flex-col bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700/60 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-getmyname-200 dark:hover:border-getmyname-700">
                        <!-- Image Area -->
                        <div class="aspect-video w-full bg-gray-50 dark:bg-gray-900 relative overflow-hidden group/image">
                            @if ($project->image)
                                <img 
                                    src="{{ Storage::url($project->image) }}" 
                                    alt="{{ $project->title }}"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                >
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-300 dark:text-gray-700">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Action Buttons Overlay -->
                            <div class="absolute top-3 right-3 flex gap-2 translate-y-[-10px] opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                <a href="{{ route('profile.projects.edit', $project) }}" class="p-2 bg-white/90 dark:bg-gray-800/90 text-gray-600 dark:text-gray-300 rounded-lg shadow-sm hover:text-getmyname-600 dark:hover:text-white backdrop-blur-md transition-colors" title="{{ __('Edit') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <form method="post" action="{{ route('profile.projects.destroy', $project) }}">
                                    @csrf
                                    @method('delete')
                                    <button 
                                        type="submit" 
                                        class="p-2 bg-white/90 dark:bg-gray-800/90 text-gray-600 dark:text-gray-300 rounded-lg shadow-sm hover:text-rose-600 dark:hover:text-rose-400 backdrop-blur-md transition-colors"
                                        onclick="return confirm('{{ __('profile.confirm_delete_project') }}')"
                                        title="{{ __('Delete') }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg line-clamp-1 group-hover:text-getmyname-600 transition-colors">{{ $project->title }}</h3>
                                @if ($project->url)
                                    <a href="{{ $project->url }}" target="_blank" class="text-gray-400 hover:text-getmyname-500 transition-colors flex-shrink-0" title="{{ $project->url }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>
                                @endif
                            </div>
                            
                            @if ($project->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ $project->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 flex flex-col items-center justify-center border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-3xl bg-gray-50/50 dark:bg-gray-900/50">
                <div class="p-4 bg-white dark:bg-gray-800 rounded-full shadow-sm mb-3">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('profile.no_projects_added') }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ __('profile.projects_subtitle') }}</p>
            </div>
        @endif
    </div>

    <!-- Add Form -->
    <div class="mt-12 bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-8 border border-gray-100 dark:border-gray-700/50">
        <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-6 flex items-center gap-2">
            <span class="w-2 h-2 bg-getmyname-500 rounded-full"></span>
            {{ __('profile.add_new_project') ?? 'Add New Project' }}
        </h3>

        <form method="post" action="{{ route('profile.projects.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="project_title" :value="__('profile.new_project_title')" />
                    <x-text-input id="project_title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" autocomplete="off" placeholder="e.g. My Awesome App" required />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div>
                    <x-input-label for="project_url" :value="__('profile.project_url') . ' (' . __('profile.optional') . ')'" />
                    <x-text-input id="project_url" name="url" type="url" class="mt-1 block w-full" :value="old('url')" autocomplete="off" placeholder="https://example.com" />
                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="project_description" :value="__('profile.project_description') . ' (' . __('profile.optional') . ')'" />
                    <x-textarea-input id="project_description" name="description" class="mt-1 block w-full" rows="3" placeholder="{{ __('profile.project_description_placeholder') }}">{{ old('description') }}</x-textarea-input>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="project_image" :value="__('profile.project_image') . ' (' . __('profile.optional') . ')'" />
                    <div class="mt-1 flex items-center justify-center w-full">
                        <label for="project_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg cursor-pointer bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-1 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or WEBP (MAX. 800x400px)</p>
                            </div>
                            <input id="project_image" name="image" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
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