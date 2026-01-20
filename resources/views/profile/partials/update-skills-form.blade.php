<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('profile.skills') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.skills_subtitle') }}
                </p>
            </div>
        </div>
    </header>

    <div class="mt-8">
        @if ($user->skills->isNotEmpty())
            <div class="flex flex-wrap gap-3">
                @foreach ($user->skills as $skill)
                    <div class="group flex items-center gap-2 px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-full transition-all hover:border-getmyname-300 dark:hover:border-getmyname-700">
                        <div class="flex flex-col leading-tight">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $skill->name }}</span>
                            @if ($skill->level)
                                <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-500">{{ $skill->level }}</span>
                            @endif
                        </div>
                        
                        <form method="post" action="{{ route('profile.skills.destroy', $skill) }}" class="inline-flex">
                            @csrf
                            @method('delete')
                            <button 
                                type="submit" 
                                class="text-gray-400 hover:text-red-500 transition-colors"
                                onclick="return confirm('{{ __('profile.confirm_delete_skill') }}')"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-4 border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-xl text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('profile.no_skills_added') }}</p>
            </div>
        @endif
    </div>

    <form method="post" action="{{ route('profile.skills.store') }}" class="mt-10 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div>
                <x-input-label for="skill_name" :value="__('profile.new_skill_name')" />
                <x-text-input id="skill_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" placeholder="e.g. Laravel" autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="skill_level" :value="__('profile.skill_level') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="skill_level" name="level" type="text" class="mt-1 block w-full" :value="old('level')" autocomplete="off" placeholder="{{ __('profile.skill_level_placeholder') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('level')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('profile.add_skill') }}
            </x-primary-button>

            @if (session('status') === 'skill-added')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('profile.skill_added_successfully') }}
                </p>
            @endif
            @if (session('status') === 'skill-deleted')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('profile.skill_removed_successfully') }}
                </p>
            @endif
        </div>
    </form>
</section>