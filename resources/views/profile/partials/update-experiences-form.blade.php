{{-- profile/partials/update-experiences-form.blade.php --}}
<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('profile.experiences') }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('profile.experiences_subtitle') }}</p>
            </div>
        </div>
    </header>

    <div class="mt-8 space-y-4">
        @forelse ($user->experiences->sortByDesc('start_date') as $experience)
            <div class="group flex items-start justify-between p-4 rounded-xl border border-gray-100 dark:border-gray-800 hover:border-getmyname-300 transition-colors">
                <div class="flex gap-4">
                    <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-900 text-gray-400 group-hover:text-getmyname-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $experience->title }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $experience->company }} • {{ $experience->location ?? 'Remote' }}</p>
                        <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider font-medium">
                            {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} — 
                            {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : __('Current') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('profile.experiences.edit', $experience) }}" class="p-2 text-gray-400 hover:text-getmyname-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </a>
                    <form method="post" action="{{ route('profile.experiences.destroy', $experience) }}">
                        @csrf @method('delete')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500" onclick="return confirm('{{ __('profile.confirm_delete_experience') }}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-8 text-center border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-2xl">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('profile.no_experiences_added') }}</p>
            </div>
        @endforelse
    </div>

    <form method="post" action="{{ route('profile.experiences.store') }}" class="mt-12 space-y-6 pt-8 border-t border-gray-100 dark:border-gray-800">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <x-input-label for="title" :value="__('Job Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" placeholder="Software Engineer" />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>
            <div>
                <x-input-label for="company" :value="__('Company')" />
                <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company')" placeholder="Acme Inc" />
                <x-input-error class="mt-2" :messages="$errors->get('company')" />
            </div>
            <div>
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" placeholder="Berlin, DE / Remote" />
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>
            <div>
                <x-input-label for="start_date" :value="__('Start Date')" />
                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date')" />
                <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
            </div>
            <div>
                <x-input-label for="end_date" :value="__('End Date (Optional)')" />
                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date')" />
                <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
            </div>
            <div class="md:col-span-3">
                <x-input-label for="description" :value="__('Description (Optional)')" />
                <x-textarea-input id="description" name="description" class="mt-1 block w-full" rows="3">{{ old('description') }}</x-textarea-input>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Add Experience') }}</x-primary-button>
            @if (session('status') === 'experience-added')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">{{ __('Added!') }}</p>
            @endif
        </div>
    </form>
</section>