@extends('layouts.profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-5xl">
                    <header class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Edit Experience') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Update your career milestone.') }}</p>
                    </header>

                    <form method="post" action="{{ route('profile.experiences.update', $experience) }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="title" :value="__('Job Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $experience->title)" />
                                <x-input-error :messages="$errors->get('title')" />
                            </div>
                            <div>
                                <x-input-label for="company" :value="__('Company')" />
                                <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $experience->company)" />
                                <x-input-error :messages="$errors->get('company')" />
                            </div>
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $experience->start_date)" />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('End Date')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date', $experience->end_date)" />
                            </div>
                            <div class="md:col-span-2">
                                <x-textarea-input id="description" name="description" class="block w-full" rows="5">{{ old('description', $experience->description) }}</x-textarea-input>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Experience') }}</x-primary-button>
                            <a href="{{ route('profile.experiences') }}" class="text-sm text-gray-600 dark:text-gray-400 underline">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection