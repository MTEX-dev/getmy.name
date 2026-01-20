@extends('layouts.profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-5xl">
                    <header class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Edit Education') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Update your educational background.') }}</p>
                    </header>

                    <form method="post" action="{{ route('profile.education.update', $education) }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="school" :value="__('School')" />
                                <x-text-input id="school" name="school" type="text" class="mt-1 block w-full" :value="old('school', $education->school)" />
                                <x-input-error :messages="$errors->get('school')" />
                            </div>
                            <div>
                                <x-input-label for="degree" :value="__('Degree')" />
                                <x-text-input id="degree" name="degree" type="text" class="mt-1 block w-full" :value="old('degree', $education->degree)" />
                                <x-input-error :messages="$errors->get('degree')" />
                            </div>
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $education->start_date)" />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('End Date')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date', $education->end_date)" />
                            </div>
                            <div class="md:col-span-2">
                                <x-textarea-input id="description" name="description" class="block w-full" rows="5">{{ old('description', $education->description) }}</x-textarea-input>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Education') }}</x-primary-button>
                            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 dark:text-gray-400 underline">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection