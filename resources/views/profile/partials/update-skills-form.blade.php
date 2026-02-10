<section x-data="{ 
    isEditModalOpen: false, 
    editingSkill: { id: '', name: '', level: '' },
    openEditModal(skill) {
        this.editingSkill = { ...skill };
        this.isEditModalOpen = true;
    }
}">
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.skills') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.skills_subtitle') }}
            </p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Skills List -->
        <div class="lg:col-span-2">
            @if ($user->skills->isNotEmpty())
                <div class="flex flex-wrap gap-3">
                    @foreach ($user->skills as $skill)
                        <div class="group flex items-center gap-3 pl-4 pr-2 py-2 bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm transition-all hover:shadow-md hover:border-getmyname-300 dark:hover:border-getmyname-600">
                            <div class="flex flex-col leading-tight cursor-default">
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $skill->name }}</span>
                                @if ($skill->level)
                                    <span class="text-[10px] uppercase font-bold tracking-tighter text-getmyname-600 dark:text-getmyname-400">{{ $skill->level }}</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center border-l border-gray-100 dark:border-gray-700 ml-1 pl-1 gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                <button 
                                    @click="openEditModal({ id: '{{ $skill->id }}', name: '{{ addslashes($skill->name) }}', level: '{{ addslashes($skill->level) }}' })"
                                    class="p-1.5 text-gray-400 hover:text-getmyname-600 dark:hover:text-white transition-colors rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L12 17.25H8.25V13.5l9.586-9.586z" /></svg>
                                </button>
                                <form method="post" action="{{ route('profile.skills.destroy', $skill) }}" class="inline-flex">
                                    @csrf
                                    @method('delete')
                                    <button 
                                        type="submit" 
                                        class="p-1.5 text-gray-400 hover:text-rose-500 transition-colors rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30"
                                        onclick="return confirm('{{ __('profile.confirm_delete_skill') }}')"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-2xl text-center flex flex-col items-center justify-center h-full">
                    <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('profile.no_skills_added') }}</p>
                </div>
            @endif
        </div>

        <!-- Right: Sticky Quick Add -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/50">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-getmyname-500 rounded-full"></span>
                    {{ __('profile.add_new_skill') }}
                </h3>
                <form method="post" action="{{ route('profile.skills.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="skill_name" :value="__('Skill Name')" class="text-xs uppercase text-gray-400" />
                        <x-text-input id="skill_name" name="name" type="text" class="mt-1 block w-full text-sm" :value="old('name')" placeholder="e.g. Laravel" required />
                    </div>
                    <div>
                        <x-input-label for="skill_level" :value="__('Level (Optional)')" class="text-xs uppercase text-gray-400" />
                        <x-text-input id="skill_level" name="level" type="text" class="mt-1 block w-full text-sm" :value="old('level')" placeholder="e.g. Advanced" />
                    </div>
                    
                    <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2 bg-gray-900 dark:bg-gray-100 border border-transparent rounded-lg font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white transition ease-in-out duration-150 mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        {{ __('Add Skill') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal (Teleported) -->
    <template x-teleport="body">
        <div 
            x-show="isEditModalOpen" 
            class="fixed inset-0 z-[110] overflow-y-auto" 
            style="display: none;"
        >
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="isEditModalOpen" x-transition.opacity @click="isEditModalOpen = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

                <div x-show="isEditModalOpen" x-transition.scale.95 class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 text-left align-middle shadow-2xl transition-all border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('profile.edit_skill') }}</h3>
                        <button @click="isEditModalOpen = false" class="text-gray-400 hover:text-gray-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>

                    <form :action="`{{ route('profile.skills.store') }}/${editingSkill.id}`" method="POST" class="space-y-4">
                        @csrf @method('PATCH')
                        <div>
                            <x-input-label for="edit_name" :value="__('profile.skill_name')" />
                            <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" x-model="editingSkill.name" required />
                        </div>
                        <div>
                            <x-input-label for="edit_level" :value="__('profile.skill_level')" />
                            <x-text-input id="edit_level" name="level" type="text" class="mt-1 block w-full" x-model="editingSkill.level" />
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="isEditModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">{{ __('Cancel') }}</button>
                            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</section>