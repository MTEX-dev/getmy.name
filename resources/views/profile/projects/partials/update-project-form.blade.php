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
            <x-input-label for="technologies" :value="__('Technologies (comma-separated)')" />
            <x-text-input id="technologies" name="technologies" type="text" class="mt-1 block w-full" :value="old('technologies', $project->technologies->pluck('technologie')->implode(','))" />
            <x-input-error class="mt-2" :messages="$errors->get('technologies')" />
        </div>

        <div>
            <x-input-label for="features" :value="__('Features (comma-separated)')" />
            <x-text-input id="features" name="features" type="text" class="mt-1 block w-full" :value="old('features', $project->features->pluck('feature')->implode(','))" />
            <x-input-error class="mt-2" :messages="$errors->get('features')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Image')" />
            <x-file-input id="image" name="image" class="mt-1 block w-full" />
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
</section>
