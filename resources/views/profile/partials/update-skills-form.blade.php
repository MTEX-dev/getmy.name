<section x-data="{ 
    isEditModalOpen: false, 
    editingSkill: { id: '', name: '', level: '' },
    openEditModal(skill) {
        this.editingSkill = { ...skill };
        this.isEditModalOpen = true;
    }
}">
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <!-- Skills List -->
    <div class="mt-8">
        @if ($user->skills->isNotEmpty())
            <div class="flex flex-wrap gap-3">
                @foreach ($user->skills as $skill)
                    <div class="group flex items-center gap-3 pl-4 pr-2 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm transition-all hover:shadow-md hover:border-getmyname-400 dark:hover:border-getmyname-500">
                        <div class="flex flex-col leading-tight cursor-default">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $skill->name }}</span>
                            @if ($skill->level)
                                <span class="text-[10px] uppercase font-bold tracking-tighter text-getmyname-500">{{ $skill->level }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center border-l border-gray-100 dark:border-gray-700 ml-1 pl-1 gap-1">
                            <!-- Edit Button -->
                            <button 
                                @click="openEditModal({ id: '{{ $skill->id }}', name: '{{ addslashes($skill->name) }}', level: '{{ addslashes($skill->level) }}' })"
                                class="p-1.5 text-gray-400 hover:text-getmyname-500 transition-colors"
                                title="{{ __('profile.edit') }}"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L12 17.25H8.25V13.5l9.586-9.586z" />
                                </svg>
                            </button>

                            <!-- Delete Button -->
                            <form method="post" action="{{ route('profile.skills.destroy', $skill) }}" class="inline-flex">
                                @csrf
                                @method('delete')
                                <button 
                                    type="submit" 
                                    class="p-1.5 text-gray-400 hover:text-rose-500 transition-colors"
                                    onclick="return confirm('{{ __('profile.confirm_delete_skill') }}')"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-2xl text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('profile.no_skills_added') }}</p>
            </div>
        @endif
    </div>

    <!-- Quick Add Form -->
    <div class="mt-10 p-6 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-800">
        <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-4">{{ __('profile.add_new_skill') }}</h3>
        <form method="post" action="{{ route('profile.skills.store') }}" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="skill_name" :value="__('profile.new_skill_name')" />
                    <x-text-input id="skill_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" placeholder="e.g. Laravel" />
                </div>
                <div>
                    <x-input-label for="skill_level" :value="__('profile.skill_level')" />
                    <x-text-input id="skill_level" name="level" type="text" class="mt-1 block w-full" :value="old('level')" placeholder="e.g. Expert" />
                </div>
            </div>
            <x-primary-button>
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('profile.add_skill') }}
            </x-primary-button>
        </form>
    </div>

    <!-- Edit Skill Modal -->
    <template x-teleport="body">
        <div 
            x-show="isEditModalOpen" 
            class="fixed inset-0 z-[110] overflow-y-auto" 
            style="display: none;"
        >
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <!-- Overlay -->
                <div 
                    x-show="isEditModalOpen" 
                    x-transition.opacity
                    @click="isEditModalOpen = false"
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                ></div>

                <!-- Modal Panel -->
                <div 
                    x-show="isEditModalOpen"
                    x-transition.scale.95
                    class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 text-left align-middle shadow-xl transition-all border border-gray-200 dark:border-gray-700"
                >
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('profile.edit_skill') }}</h3>
                        <button @click="isEditModalOpen = false" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form :action="`{{ route('profile.skills.store') }}/${editingSkill.id}`" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <x-input-label for="edit_name" :value="__('profile.skill_name')" />
                            <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" x-model="editingSkill.name" required />
                        </div>

                        <div>
                            <x-input-label for="edit_level" :value="__('profile.skill_level')" />
                            <x-text-input id="edit_level" name="level" type="text" class="mt-1 block w-full" x-model="editingSkill.level" />
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button 
                                type="button" 
                                @click="isEditModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                            >
                                {{ __('profile.cancel') }}
                            </button>
                            <x-primary-button>
                                {{ __('profile.save_changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</section>