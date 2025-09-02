<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.skills') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.skills_subtitle') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if ($user->skills->isNotEmpty())
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('profile.your_current_skills') }}</h3>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                @foreach ($user->skills as $skill)
                    <li class="flex items-center justify-between py-1">
                        <span>
                            <span class="font-semibold">{{ $skill->name }}</span>
                            @if ($skill->level)
                                ({{ $skill->level }})
                            @endif
                        </span>
                        <form method="post" action="{{ route('profile.skills.destroy', $skill) }}" class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm ml-4" onclick="return confirm('{{ __('profile.confirm_delete_skill') }}')">
                                {{ __('profile.remove') }}
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.no_skills_added') }}</p>
        @endif
    </div>

    <form method="post" action="{{ route('profile.skills.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="skill_name" :value="__('profile.new_skill_name')" />
            <x-text-input id="skill_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="skill_level" :value="__('profile.skill_level') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="skill_level" name="level" type="text" class="mt-1 block w-full" :value="old('level')" autocomplete="off" placeholder="{{ __('profile.skill_level_placeholder') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('level')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.add_skill') }}</x-primary-button>

            @if (session('status') === 'skill-added')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >{{ __('profile.skill_added_successfully') }}</p>
            @endif
            @if (session('status') === 'skill-deleted')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >{{ __('profile.skill_removed_successfully') }}</p>
            @endif
        </div>
    </form>
</section>