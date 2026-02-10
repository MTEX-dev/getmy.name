<section>
    <!-- Header with Gradient Icon -->
    <header class="flex items-start justify-between border-b border-gray-100 dark:border-gray-700 pb-8 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('profile.education') }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-lg leading-relaxed">{{ __('profile.education_subtitle') }}</p>
            </div>
        </div>
    </header>

    <div class="grid lg:grid-cols-3 gap-12">
        <!-- Left: List / Timeline -->
        <div class="lg:col-span-2 space-y-8">
            <div class="relative">
                @if($user->education->isNotEmpty())
                    <!-- Timeline Vertical Line -->
                    <div class="absolute left-6 top-4 bottom-4 w-px bg-gray-200 dark:bg-gray-700"></div>
                @endif

                @forelse ($user->education->sortByDesc('start_date') as $education)
                    <div class="group relative flex gap-6 mb-8 last:mb-0 pl-2">
                        <!-- Timeline Dot -->
                        <div class="flex-shrink-0 mt-1.5 h-3 w-3 rounded-full border-2 border-white dark:border-gray-800 bg-getmyname-500 shadow-md ring-4 ring-gray-50 dark:ring-gray-900 z-10"></div>
                        
                        <div class="flex-1 bg-white dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50 rounded-2xl p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:border-getmyname-200 dark:hover:border-getmyname-800 hover:-translate-y-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $education->degree }}</h4>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($education->start_date)->format('Y') }} — 
                                            {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('Y') : __('Present') }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-getmyname-600 dark:text-getmyname-400">
                                        {{ $education->school }} 
                                        @if($education->field_of_study)
                                            <span class="text-gray-400 dark:text-gray-600 mx-1">•</span> {{ $education->field_of_study }}
                                        @endif
                                    </p>
                                    @if($education->description)
                                        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $education->description }}</p>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 -mr-2 -mt-2">
                                    <a href="{{ route('profile.education.edit', $education) }}" class="p-2 text-gray-400 hover:text-getmyname-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors" title="{{ __('Edit') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form method="post" action="{{ route('profile.education.destroy', $education) }}">
                                        @csrf @method('delete')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg transition-colors" onclick="return confirm('{{ __('profile.confirm_delete_education') }}')" title="{{ __('Delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 flex flex-col items-center justify-center border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-3xl bg-gray-50/50 dark:bg-gray-900/50">
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-full shadow-sm mb-3">
                             <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('profile.no_education_added') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Add New Form (Sticky) -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/50">
                <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-6">{{ __('Add New') }}</h3>
                
                <form method="post" action="{{ route('profile.education.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="school" :value="__('School / University')" class="text-xs uppercase text-gray-400" />
                        <x-text-input id="school" name="school" type="text" class="mt-1 block w-full text-sm" :value="old('school')" placeholder="e.g. Harvard University" required />
                        <x-input-error class="mt-1" :messages="$errors->get('school')" />
                    </div>

                    <div>
                        <x-input-label for="degree" :value="__('Degree')" class="text-xs uppercase text-gray-400" />
                        <x-text-input id="degree" name="degree" type="text" class="mt-1 block w-full text-sm" :value="old('degree')" placeholder="e.g. BSc Computer Science" required />
                        <x-input-error class="mt-1" :messages="$errors->get('degree')" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label for="start_date" :value="__('Start')" class="text-xs uppercase text-gray-400" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full text-sm" :value="old('start_date')" required />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('End')" class="text-xs uppercase text-gray-400" />
                            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full text-sm" :value="old('end_date')" />
                        </div>
                    </div>
                     <x-input-error class="mt-1" :messages="$errors->get('start_date')" />

                    <div>
                        <x-input-label for="field_of_study" :value="__('Field of Study (Optional)')" class="text-xs uppercase text-gray-400" />
                        <x-text-input id="field_of_study" name="field_of_study" type="text" class="mt-1 block w-full text-sm" :value="old('field_of_study')" />
                    </div>

                    <div>
                         <x-input-label for="description" :value="__('Description (Optional)')" class="text-xs uppercase text-gray-400" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-md shadow-sm text-sm">{{ old('description') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2 bg-gray-900 dark:bg-gray-100 border border-transparent rounded-lg font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            {{ __('Add') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>