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
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('profile.your_current_projects') }}</h3>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                @foreach ($user->projects as $project)
                    <li class="flex items-center justify-between py-1">
                        <span>
                            <span class="font-semibold">{{ $project->name }}</span>
                            @if ($project->level)
                                ({{ $project->level }})
                            @endif
                        </span>
                        <form method="post" action="{{ route('profile.projects.destroy', $project) }}" class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm ml-4" onclick="return confirm('{{ __('profile.confirm_delete_project') }}')">
                                {{ __('profile.remove') }}
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.no_projects_added') }}</p>
        @endif
    </div>

    <form method="post" action="{{ route('profile.projects.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="project_name" :value="__('profile.new_project_name')" />
            <x-text-input id="project_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="project_level" :value="__('profile.project_level') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="project_level" name="level" type="text" class="mt-1 block w-full" :value="old('level')" autocomplete="off" placeholder="{{ __('profile.project_level_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('level')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.add_project') }}</x-primary-button>

            @if (session('status') === 'project-added')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >{{ __('profile.project_added_successfully') }}</p>
            @endif
            @if (session('status') === 'project-deleted')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >{{ __('profile.project_removed_successfully') }}</p>
            @endif
        </div>
    </form>
</section>