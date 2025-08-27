@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create Your Portfolio Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Start building your developer portfolio by creating your profile.
                </p>

                <form method="post" action="{{ route('profiles.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                        <p class="mt-2 text-sm text-gray-500">This will be part of your public API URL (e.g., getmy.name/api/<span class="font-bold">username</span>).</p>
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Your Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        <p class="mt-2 text-sm text-gray-500">e.g., Senior Laravel Developer, Fullstack Engineer</p>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Public Contact Email (Optional)')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        <p class="mt-2 text-sm text-gray-500">An email visible on your public profile/API for contact.</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Create Profile') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection