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
            <x-textarea-input id="description" name="description" class="mt-1 block w-full">{{ old('description', $project->description) }}</x-textarea-input>
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
            <x-textarea-input id="challenges" name="challenges" class="mt-1 block w-full">{{ old('challenges', $project->challenges) }}</x-textarea-input>
            <x-input-error class="mt-2" :messages="$errors->get('challenges')" />
        </div>

        <div>
            <x-input-label for="technologies" :value="__('Technologies')" />
            <div class="mt-1 space-y-2">
                @foreach ($project->technologies as $technology)
                    <div class="flex items-center gap-2">
                        <x-text-input name="technologies[{{ $technology->uuid }}]" type="text" class="block w-full" :value="old('technologies[' . $technology->uuid . ']', $technology->technologie)" />
                        <x-danger-button form="remove-technology-{{ $technology->uuid }}">{{ __('Remove') }}</x-danger-button>
                    </div>
                @endforeach
                <div class="flex items-center gap-2">
                    <x-text-input name="new_technologies[]" type="text" class="block w-full" placeholder="{{ __('Add New Technology') }}" />
                    <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-technology')">{{ __('Add More') }}</x-secondary-button>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('technologies')" />
            <x-input-error class="mt-2" :messages="$errors->get('new_technologies.*')" />
        </div>

        <div>
            <x-input-label for="features" :value="__('Features')" />
            <div class="mt-1 space-y-2">
                @foreach ($project->features as $feature)
                    <div class="flex items-center gap-2">
                        <x-text-input name="features[{{ $feature->uuid }}]" type="text" class="block w-full" :value="old('features[' . $feature->uuid . ']', $feature->feature)" />
                        <x-danger-button form="remove-feature-{{ $feature->uuid }}">{{ __('Remove') }}</x-danger-button>
                    </div>
                @endforeach
                <div class="flex items-center gap-2">
                    <x-text-input name="new_features[]" type="text" class="block w-full" placeholder="{{ __('Add New Feature') }}" />
                    <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-feature')">{{ __('Add More') }}</x-secondary-button>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('features')" />
            <x-input-error class="mt-2" :messages="$errors->get('new_features.*')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Image')" />
            <x-file-input id="image" name="image" class="mt-1 block w-full" />
            @if ($project->image)
                <div class="mt-2">
                    <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="h-20 w-20 object-cover">
                    <x-danger-button class="mt-2" form="remove-image-form">{{ __('Remove Image') }}</x-danger-button>
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
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

    @foreach ($project->technologies as $technology)
        <form id="remove-technology-{{ $technology->uuid }}" method="post" action="{{ route('profile.projects.technologies.remove', [$project, $technology->uuid]) }}" class="hidden">
            @csrf
            @method('delete')
        </form>
    @endforeach

    @foreach ($project->features as $feature)
        <form id="remove-feature-{{ $feature->uuid }}" method="post" action="{{ route('profile.projects.features.remove', [$project, $feature->uuid]) }}" class="hidden">
            @csrf
            @method('delete')
        </form>
    @endforeach

    @if ($project->image)
        <form id="remove-image-form" method="post" action="{{ route('profile.projects.image.remove', $project) }}" class="hidden">
            @csrf
            @method('delete')
        </form>
    @endif

    <x-modal name="add-technology" :show="$errors->has('new_technology')" focusable>
        <form method="post" action="{{ route('profile.projects.technologies.add', $project) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add New Technology') }}
            </h2>
            <div class="mt-6">
                <x-input-label for="new_technology" value="{{ __('Technology Name') }}" />
                <x-text-input id="new_technology" name="technologie" type="text" class="mt-1 block w-full" placeholder="{{ __('Technology Name') }}" />
                <x-input-error :messages="$errors->get('new_technology')" class="mt-2" />
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

    <x-modal name="add-feature" :show="$errors->has('new_feature')" focusable>
        <form method="post" action="{{ route('profile.projects.features.add', $project) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add New Feature') }}
            </h2>
            <div class="mt-6">
                <x-input-label for="new_feature" value="{{ __('Feature Name') }}" />
                <x-text-input id="new_feature" name="feature" type="text" class="mt-1 block w-full" placeholder="{{ __('Feature Name') }}" />
                <x-input-error :messages="$errors->get('new_feature')" class="mt-2" />
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
</section>