<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.projects') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.projects_subtitle') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if ($user->projects->isNotEmpty())
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.your_current_projects') }}</h3>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                @foreach ($user->projects as $project)
                    <li class="flex items-center justify-between py-1">
                        <span>
                            <span class="font-semibold">{{ $project->title }}</span>
                            @if ($project->description)
                                - {{ $project->description }}
                            @endif
                            @if ($project->url)
                                (<a href="{{ $project->url }}" target="_blank"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">{{ parse_url($project->url, PHP_URL_HOST) }}</a>)
                            @endif
                            @if ($project->image)
                                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}"
                                    class="h-8 w-8 inline-block ml-2 rounded-full object-cover">
                            @endif
                        </span>
                        <div class="flex items-center">
                            <a href="{{ route('profile.projects.edit', $project) }}"
                               class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm">
                                {{ __('profile.edit') }}
                            </a>
                            <form method="post" action="{{ route('profile.projects.destroy', $project) }}"
                                  class="inline">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm ml-4"
                                        onclick="return confirm('{{ __('profile.confirm_delete_project') }}')">
                                    {{ __('profile.remove') }}
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.no_projects_added') }}</p>
        @endif
    </div>

    <form method="post" action="{{ route('profile.projects.store') }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="project_title" :value="__('profile.new_project_title')" />
            <x-text-input id="project_title" name="title" type="text" class="mt-1 block w-full"
                :value="old('title')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="project_description" :value="__('profile.project_description') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="project_description" name="description" type="text"
                class="mt-1 block w-full" :value="old('description')" autocomplete="off"
                placeholder="{{ __('profile.project_description_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="project_url" :value="__('profile.project_url') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="project_url" name="url" type="url" class="mt-1 block w-full"
                :value="old('url')" autocomplete="off"
                placeholder="{{ __('profile.project_url_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('url')" />
        </div>

        <div>
            <x-input-label for="project_image" :value="__('profile.project_image') . ' (' . __('profile.optional') . ')'" />
            <x-file-input id="project_image" name="image" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.add_project') }}</x-primary-button>

            @if (session('status') === 'project-added')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">{{ __('profile.project_added_successfully') }}
                </p>
            @endif
            @if (session('status') === 'project-deleted')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">
                    {{ __('profile.project_removed_successfully') }}</p>
            @endif
        </div>
    </form>
</section>