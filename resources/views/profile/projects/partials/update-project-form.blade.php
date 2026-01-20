<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Project Information') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __("Update the project's details and showcase your work.") }}
                </p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('profile.projects.update', $project) }}" class="mt-8 space-y-10" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="md:col-span-2">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $project->title)" autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="role" :value="__('Your Role')" />
                <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role', $project->role)" placeholder="e.g. Lead Developer" />
                <x-input-error class="mt-2" :messages="$errors->get('role')" />
            </div>

            <div>
                <x-input-label for="url" :value="__('Project URL')" />
                <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="old('url', $project->url)" />
                <x-input-error class="mt-2" :messages="$errors->get('url')" />
            </div>

            <div>
                <x-input-label for="github_url" :value="__('GitHub URL')" />
                <x-text-input id="github_url" name="github_url" type="url" class="mt-1 block w-full" :value="old('github_url', $project->github_url)" />
                <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
            </div>

            <div>
                <x-input-label for="live_demo_url" :value="__('Live Demo URL')" />
                <x-text-input id="live_demo_url" name="live_demo_url" type="url" class="mt-1 block w-full" :value="old('live_demo_url', $project->live_demo_url)" />
                <x-input-error class="mt-2" :messages="$errors->get('live_demo_url')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea-input id="description" name="description" class="mt-1 block w-full" rows="4" value="{{ old('description', $project->description) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div>
                <x-input-label for="challenges" :value="__('Challenges')" />
                <x-textarea-input id="challenges" name="challenges" class="mt-1 block w-full" rows="4" value="{{ old('challenges', $project->challenges) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('challenges')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-6 border-t border-gray-100 dark:border-gray-800">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <x-input-label :value="__('Technologies')" class="text-base font-bold" />
                    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-technology')" class="text-sm font-semibold text-getmyname-600 hover:text-getmyname-700 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Add') }}
                    </button>
                </div>
                <div class="space-y-3">
                    @forelse ($project->technologies as $technology)
                        <div class="flex items-center gap-2 group">
                            <form method="post" action="{{ route('profile.projects.technologies.update', [$project, $technology]) }}" class="flex-grow">
                                @csrf
                                @method('patch')
                                <x-text-input name="technologie" type="text" class="block w-full py-1.5 text-sm" :value="old('technologie', $technology->technologie)" />
                            </form>
                            <form method="post" action="{{ route('profile.projects.technologies.remove', [$project, $technology]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">{{ __('No technologies listed.') }}</p>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <x-input-label :value="__('Key Features')" class="text-base font-bold" />
                    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-feature')" class="text-sm font-semibold text-getmyname-600 hover:text-getmyname-700 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Add') }}
                    </button>
                </div>
                <div class="space-y-3">
                    @forelse ($project->features as $feature)
                        <div class="flex items-center gap-2 group">
                            <form method="post" action="{{ route('profile.projects.features.update', [$project, $feature]) }}" class="flex-grow">
                                @csrf
                                @method('patch')
                                <x-text-input name="feature" type="text" class="block w-full py-1.5 text-sm" :value="old('feature', $feature->feature)" />
                            </form>
                            <form method="post" action="{{ route('profile.projects.features.remove', [$project, $feature]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">{{ __('No features listed.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
            <x-input-label for="image" :value="__('Project Hero Image')" class="mb-4" />
            <div class="flex flex-col md:flex-row items-start gap-6">
                @if ($project->image)
                    <div class="relative group">
                        <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-40 aspect-video object-cover rounded-xl border border-gray-200 dark:border-gray-700">
                        <form method="post" action="{{ route('profile.projects.image.remove', $project) }}" class="absolute -top-2 -right-2">
                            @csrf
                            @method('delete')
                            <button type="submit" class="bg-red-500 text-white rounded-full p-1 shadow-lg hover:bg-red-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </form>
                    </div>
                @endif
                <div class="flex-1 w-full">
                    <x-file-input id="image" name="image" class="block w-full" />
                    <p class="mt-2 text-xs text-gray-500">Recommended: 1200x630px. Max 2MB.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6">
            <x-primary-button class="px-8">{{ __('Save Project') }}</x-primary-button>

            @if (session('status') === 'project-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Saved successfully.') }}
                </div>
            @endif
        </div>
    </form>

    <x-modal name="add-technology" :show="$errors->has('technologie') && session('modal-type') === 'add-technology'" focusable>
        <form method="post" action="{{ route('profile.projects.technologies.add', $project) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Add New Technology') }}</h2>
            <div class="mt-6">
                <x-input-label for="new_technology_name" value="{{ __('Technology Name') }}" />
                <x-text-input id="new_technology_name" name="technologie" type="text" class="mt-1 block w-full" placeholder="e.g. Tailwind CSS" />
                <x-input-error :messages="$errors->get('technologie')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-primary-button>{{ __('Add Technology') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-modal name="add-feature" :show="$errors->has('feature') && session('modal-type') === 'add-feature'" focusable>
        <form method="post" action="{{ route('profile.projects.features.add', $project) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Add New Feature') }}</h2>
            <div class="mt-6">
                <x-input-label for="new_feature_name" value="{{ __('Feature Name') }}" />
                <x-text-input id="new_feature_name" name="feature" type="text" class="mt-1 block w-full" placeholder="e.g. Real-time notifications" />
                <x-input-error :messages="$errors->get('feature')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-primary-button>{{ __('Add Feature') }}</x-primary-button>
            </div>
        </form>
    </x-modal>
</section>