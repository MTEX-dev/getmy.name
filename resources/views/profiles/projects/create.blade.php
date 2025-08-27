@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add New Project') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Add a new project to your portfolio profile.
                </p>

                <form method="post" action="{{ route('profiles.projects.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Project Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-textarea id="description" name="description" class="mt-1 block w-full">{{ old('description') }}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="url" :value="__('Project URL (Optional)')" />
                        <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="old('url')" placeholder="https://example.com/project" />
                        <x-input-error class="mt-2" :messages="$errors->get('url')" />
                    </div>

                    <div>
                        <x-input-label for="image" :value="__('Project Image (Optional, Max 2MB)')" />
                        <input
                            id="image"
                            name="image"
                            type="file"
                            class="form-input file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-900 dark:file:text-violet-300 dark:hover:file:bg-violet-800
                                   block w-full text-sm text-gray-900 dark:text-gray-400
                                   border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer
                                   bg-gray-50 dark:bg-gray-700
                                   focus:outline-none focus:ring focus:ring-violet-200 dark:focus:ring-violet-700"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Add Project') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection