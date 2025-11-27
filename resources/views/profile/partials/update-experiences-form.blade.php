<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.experiences') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.experiences_subtitle') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if ($user->experiences->isNotEmpty())
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.your_current_experiences') }}</h3>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                @foreach ($user->experiences as $experience)
                    <li class="flex items-center justify-between py-1">
                        <span>
                            <span class="font-semibold">{{ $experience->title }}</span>
                            @if ($experience->company)
                                - {{ $experience->company }}
                            @endif
                            @if ($experience->start_date && $experience->end_date)
                                ({{ $experience->start_date }} - {{ $experience->end_date }})
                            @elseif($experience->start_date)
                                ({{ $experience->start_date }} - {{ __('profile.experiences.current') }})
                            @endif
                            @if ($experience->description)
                                <br>{{ $experience->description }}
                            @endif
                        </span>
                        <form method="post" action="{{ route('profile.experiences.destroy', $experience) }}"
                            class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm ml-4"
                                onclick="return confirm('{{ __('profile.confirm_delete_experience') }}')">
                                {{ __('profile.remove') }}
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.no_experiences_added') }}</p>
        @endif
    </div>

    <form method="post" action="{{ route('profile.experiences.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="experience_title" :value="__('profile.experience_title')" />
            <x-text-input id="experience_title" name="title" type="text" class="mt-1 block w-full"
                :value="old('title')"  autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="experience_company" :value="__('profile.experience_company')" />
            <x-text-input id="experience_company" name="company" type="text" class="mt-1 block w-full"
                :value="old('company')"  autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('company')" />
        </div>

        <div>
            <x-input-label for="experience_location" :value="__('profile.location') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="experience_location" name="location" type="text" class="mt-1 block w-full"
                :value="old('location')" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <div>
            <x-input-label for="experience_start_date" :value="__('profile.start_date')" />
            <x-text-input id="experience_start_date" name="start_date" type="date"
                class="mt-1 block w-full" :value="old('start_date')"  autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
        </div>

        <div>
            <x-input-label for="experience_end_date" :value="__('profile.end_date') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="experience_end_date" name="end_date" type="date"
                class="mt-1 block w-full" :value="old('end_date')" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
        </div>

        <div>
            <x-input-label for="experience_description" :value="__('profile.experience_description') . ' (' . __('profile.optional') . ')'" />
            <x-textarea-input id="experience_description" name="description" class="mt-1 block w-full"
                autocomplete="off">{{ old('description') }}</x-textarea-input>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.add_experience') }}</x-primary-button>

            @if (session('status') === 'experience-added')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">{{ __('profile.experience_added_successfully') }}
                </p>
            @endif
            @if (session('status') === 'experience-deleted')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">
                    {{ __('profile.experience_removed_successfully') }}</p>
            @endif
        </div>
    </form>
</section>