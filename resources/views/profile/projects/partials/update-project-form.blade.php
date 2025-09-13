<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Project Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update the project's information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.projects.update', $project) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $project->title)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-textarea-input id="description" name="description" class="mt-1 block w-full" value="{{ old('description', $project->description) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="url" :value="__('URL')" />
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

        <div>
            <x-input-label for="role" :value="__('Your Role')" />
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role', $project->role)" />
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        <div>
            <x-input-label for="challenges" :value="__('Challenges')" />
            <x-textarea-input id="challenges" name="challenges" class="mt-1 block w-full" value="{{ old('challenges', $project->challenges) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('challenges')" />
        </div>

        <div class="pt-6">
            <x-input-label for="technologies" :value="__('Technologies')" />
            <div class="mt-2 space-y-2">
                @foreach ($project->technologies as $technology)
                    <div class="flex items-center gap-2">
                        <form method="post" action="{{ route('profile.projects.technologies.update', [$project, $technology]) }}" class="flex-grow">
                            @csrf
                            @method('patch')
                            <x-text-input name="technologie" type="text" class="block w-full" :value="old('technologie', $technology->technologie)" />
                            <x-input-error class="mt-2" :messages="$errors->get('technologie')" />
                        </form>
                        <form method="post" action="{{ route('profile.projects.technologies.remove', [$project, $technology]) }}">
                            @csrf
                            @method('delete')
                            <x-danger-button type="submit">{{ __('Remove') }}</x-danger-button>
                        </form>
                    </div>
                @endforeach
                <x-modal name="add-technology" :show="$errors->has('technologie') && session('modal-type') === 'add-technology'" focusable>
                    <form method="post" action="{{ route('profile.projects.technologies.add', $project) }}" class="p-6">
                        @csrf
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Add New Technology') }}
                        </h2>
                        <div class="mt-6">
                            <x-input-label for="new_technology_name" value="{{ __('Technology Name') }}" />
                            <x-text-input id="new_technology_name" name="technologie" type="text" class="mt-1 block w-full" placeholder="{{ __('Technology Name') }}" />
                            <x-input-error :messages="$errors->get('technologie')" class="mt-2" />
                        </div>
                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ms-3">
                                {{ __('Add Technology') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
                <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-technology'); $nextTick(() => document.getElementById('new_technology_name').focus());">
                    {{ __('Add New Technology') }}
                </x-secondary-button>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('technologies')" />
        </div>

        <div class="pt-6">
            <x-input-label for="features" :value="__('Features')" />
            <div class="mt-2 space-y-2">
                @foreach ($project->features as $feature)
                    <div class="flex items-center gap-2">
                        <form method="post" action="{{ route('profile.projects.features.update', [$project, $feature]) }}" class="flex-grow">
                            @csrf
                            @method('patch')
                            <x-text-input name="feature" type="text" class="block w-full" :value="old('feature', $feature->feature)" />
                            <x-input-error class="mt-2" :messages="$errors->get('feature')" />
                        </form>
                        <form method="post" action="{{ route('profile.projects.features.remove', [$project, $feature]) }}">
                            @csrf
                            @method('delete')
                            <x-danger-button type="submit">{{ __('Remove') }}</x-danger-button>
                        </form>
                    </div>
                @endforeach
                <x-modal name="add-feature" :show="$errors->has('feature') && session('modal-type') === 'add-feature'" focusable>
                    <form method="post" action="{{ route('profile.projects.features.add', $project) }}" class="p-6">
                        @csrf
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Add New Feature') }}
                        </h2>
                        <div class="mt-6">
                            <x-input-label for="new_feature_name" value="{{ __('Feature Name') }}" />
                            <x-text-input id="new_feature_name" name="feature" type="text" class="mt-1 block w-full" placeholder="{{ __('Feature Name') }}" />
                            <x-input-error :messages="$errors->get('feature')" class="mt-2" />
                        </div>
                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ms-3">
                                {{ __('Add Feature') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
                <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-feature'); $nextTick(() => document.getElementById('new_feature_name').focus());">
                    {{ __('Add New Feature') }}
                </x-secondary-button>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('features')" />
        </div>

        <div class="pt-6">
            <x-input-label for="image" :value="__('Image')" />
            <x-file-input id="image" name="image" class="mt-1 block w-full" />
            @if ($project->image)
                <div class="mt-4">
                    <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="h-20 w-20 object-cover">
                    <form id="remove-image-form" method="post" action="{{ route('profile.projects.image.remove', $project) }}" class="mt-4">
                        @csrf
                        @method('delete')
                        <x-danger-button type="submit">{{ __('Remove Image') }}</x-danger-button>
                    </form>
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4 pt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'project-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>