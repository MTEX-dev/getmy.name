@extends('layouts.profile')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Social Links') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Manage the social media and website links for your public profile.
                </p>

                <form method="post" action="{{ route('profiles.socials.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="github" :value="__('GitHub Username')" />
                        <x-text-input id="github" name="github" type="text" class="mt-1 block w-full" :value="old('github', $socials?->github)" placeholder="YourGitHubUsername" />
                        <x-input-error class="mt-2" :messages="$errors->get('github')" />
                    </div>

                    <div>
                        <x-input-label for="linkedin" :value="__('LinkedIn Profile ID')" />
                        <x-text-input id="linkedin" name="linkedin" type="text" class="mt-1 block w-full" :value="old('linkedin', $socials?->linkedin)" placeholder="your-linkedin-id" />
                        <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
                    </div>

                    <div>
                        <x-input-label for="twitter" :value="__('Twitter Username')" />
                        <x-text-input id="twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $socials?->twitter)" placeholder="YourTwitterHandle" />
                        <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
                    </div>

                    <div>
                        <x-input-label for="personal_website" :value="__('Personal Website URL')" />
                        <x-text-input id="personal_website" name="personal_website" type="url" class="mt-1 block w-full" :value="old('personal_website', $socials?->personal_website)" placeholder="https://yourwebsite.com" />
                        <x-input-error class="mt-2" :messages="$errors->get('personal_website')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Social Links') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection