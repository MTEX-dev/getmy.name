<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.education') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.education_subtitle') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if ($user->education->isNotEmpty())
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.your_current_education') }}</h3>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                @foreach ($user->education as $education)
                    <li class="flex items-center justify-between py-1">
                        <span>
                            <span class="font-semibold">{{ $education->degree }}</span>
                            @if ($education->school)
                                - {{ $education->school }}
                            @endif
                            @if ($education->start_date && $education->end_date)
                                ({{ $education->start_date }} - {{ $education->end_date }})
                            @elseif($education->start_date)
                                ({{ $education->start_date }} - {{ __('profile.education.current') }})
                            @endif
                            @if ($education->description)
                                <br>{{ $education->description }}
                            @endif
                        </span>
                        <form method="post" action="{{ route('profile.education.destroy', $education) }}"
                            class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm ml-4"
                                onclick="return confirm('{{ __('profile.confirm_delete_education') }}')">
                                {{ __('profile.remove') }}
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.no_education_added') }}</p>
        @endif
    </div>

    <form method="post" action="{{ route('profile.education.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="education_school" :value="__('profile.school')" />
            <x-text-input id="education_school" name="school" type="text" class="mt-1 block w-full"
                :value="old('school')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('school')" />
        </div>

        <div>
            <x-input-label for="education_degree" :value="__('profile.degree')" />
            <x-text-input id="education_degree" name="degree" type="text" class="mt-1 block w-full"
                :value="old('degree')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('degree')" />
        </div>

        <div>
            <x-input-label for="education_field_of_study" :value="__('profile.field_of_study') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="education_field_of_study" name="field_of_study" type="text"
                class="mt-1 block w-full" :value="old('field_of_study')" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('field_of_study')" />
        </div>

        <div>
            <x-input-label for="education_start_date" :value="__('profile.start_date')" />
            <x-text-input id="education_start_date" name="start_date" type="date"
                class="mt-1 block w-full" :value="old('start_date')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
        </div>

        <div>
            <x-input-label for="education_end_date" :value="__('profile.end_date') . ' (' . __('profile.optional') . ')'" />
            <x-text-input id="education_end_date" name="end_date" type="date"
                class="mt-1 block w-full" :value="old('end_date')" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
        </div>

        <div>
            <x-input-label for="education_description" :value="__('profile.education_description') . ' (' . __('profile.optional') . ')'" />
            <x-textarea-input id="education_description" name="description" class="mt-1 block w-full"
                autocomplete="off">{{ old('description') }}</x-textarea-input>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.add_education') }}</x-primary-button>

            @if (session('status') === 'education-added')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">{{ __('profile.education_added_successfully') }}
                </p>
            @endif
            @if (session('status') === 'education-deleted')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">
                    {{ __('profile.education_removed_successfully') }}</p>
            @endif
        </div>
    </form>
</section>