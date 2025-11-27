@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Your Portfolio Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 p-4 rounded-md mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 p-4 rounded-md mb-4" role="alert">
                    {{ session('warning') }}
                </div>
            @endif

            {{-- Profile Details --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $profile->username }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 text-lg">{{ $profile->title }}</p>
                    @if ($profile->email)
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Contact: {{ $profile->email }}</p>
                    @endif
                    <p class="text-gray-500 dark:text-gray-500 text-xs mt-2">
                        Public API Endpoint: <code class="text-getmyname-600 dark:text-getmyname-400">https://getmy.name/api/{{ $profile->username }}</code>
                    </p>
                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button-redirect :href="route('profiles.edit')">{{ __('Edit Core Info') }}</x-primary-button-redirect>
                    </div>
                </div>
            </div>

            {{-- Skills --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Skills') }}</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                        @forelse ($profile->skills as $skill)
                            <li class="flex items-center justify-between py-1">
                                <span>{{ $skill->name }}</span>
                                <form method="post" action="{{ route('profiles.skills.destroy', $skill) }}" class="inline ml-4">
                                    @csrf
                                    @method('delete')
                                    <x-danger-button type="submit" class="p-1 px-2 text-xs">{{ __('Remove') }}</x-danger-button>
                                </form>
                            </li>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No skills added yet.') }}</p>
                        @endforelse
                    </ul>
                    <form method="post" action="{{ route('profiles.skills.store') }}" class="mt-6 flex items-center gap-2">
                        @csrf
                        <x-text-input id="new_skill" name="name" type="text" class="block flex-grow" placeholder="{{ __('New Skill Name') }}" />
                        <x-primary-button>{{ __('Add Skill') }}</x-primary-button>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </form>
                </div>
            </div>

            {{-- Projects --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Projects') }}</h3>
                    @forelse ($profile->projects as $project)
                        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">{{ $project->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $project->description }}</p>
                            @if ($project->url)
                                <a href="{{ $project->url }}" target="_blank" class="text-getmyname-600 dark:text-getmyname-400 text-sm hover:underline mt-1 block">View Project</a>
                            @endif
                            @if ($project->image_path)
                                <img src="{{ $project->imageUrl() }}" alt="{{ $project->name }}" class="mt-3 w-32 h-20 object-cover rounded-md" />
                            @endif
                            <div class="mt-3 flex gap-2">
                                <x-primary-button-redirect href="{{ route('profiles.projects.edit', $project) }}" class="p-1 px-2 text-xs">{{ __('Edit') }}</x-primary-button-redirect>
                                <form method="post" action="{{ route('profiles.projects.destroy', $project) }}" class="inline">
                                    @csrf
                                    @method('delete')
                                    <x-danger-button type="submit" class="p-1 px-2 text-xs">{{ __('Remove') }}</x-danger-button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">{{ __('No projects added yet.') }}</p>
                    @endforelse
                    <div class="mt-6">
                        <x-primary-button-redirect href="{{ route('profiles.projects.create') }}">{{ __('Add New Project') }}</x-primary-button-redirect>
                    </div>
                </div>
            </div>

            {{-- Socials --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Social Links') }}</h3>
                    @if ($profile->socials)
                        <ul class="text-gray-700 dark:text-gray-300 space-y-2">
                            @if ($profile->socials->github)
                                <li>GitHub: <a href="https://github.com/{{ $profile->socials->github }}" target="_blank" class="text-getmyname-600 dark:text-getmyname-400 hover:underline">{{ $profile->socials->github }}</a></li>
                            @endif
                            @if ($profile->socials->linkedin)
                                <li>LinkedIn: <a href="https://linkedin.com/in/{{ $profile->socials->linkedin }}" target="_blank" class="text-getmyname-600 dark:text-getmyname-400 hover:underline">{{ $profile->socials->linkedin }}</a></li>
                            @endif
                            @if ($profile->socials->twitter)
                                <li>Twitter: <a href="https://twitter.com/{{ $profile->socials->twitter }}" target="_blank" class="text-getmyname-600 dark:text-getmyname-400 hover:underline">{{ $profile->socials->twitter }}</a></li>
                            @endif
                            @if ($profile->socials->personal_website)
                                <li>Website: <a href="{{ $profile->socials->personal_website }}" target="_blank" class="text-getmyname-600 dark:text-getmyname-400 hover:underline">{{ $profile->socials->personal_website }}</a></li>
                            @endif
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">{{ __('No social links added yet.') }}</p>
                    @endif
                    <div class="mt-6">
                        <x-primary-button-redirect href="{{ route('profiles.socials.edit') }}">{{ __('Edit Social Links') }}</x-primary-button-redirect>
                    </div>
                </div>
            </div>

            {{-- Delete Profile --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profiles.partials.delete-profile-form')
                </div>
            </div>
        </div>
    </div>
@endsection
