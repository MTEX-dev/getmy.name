@extends('layouts.profile')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('API Tokens') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Create API Token') }}
                    </h3>

                    <form method="POST" action="{{ route('profile.api-tokens.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Token Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"  autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Permissions') }}
                            </h4>

                            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($availableAbilities as $ability)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="abilities[]" value="{{ $ability }}" class="rounded border-gray-300 text-getmyname-600 shadow-sm focus:ring-getmyname-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-getmyname-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $ability }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Manage API Tokens') }}
                    </h3>

                    <div class="mt-6 space-y-6">
                        @foreach ($tokens as $token)
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $token->name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        @if ($token->last_used_at)
                                            {{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <form method="POST" action="{{ route('profile.api-tokens.destroy', $token->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('status') === 'api-token-created')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg">
            <p class="font-bold">{{ __('API Token Created') }}</p>
            <p>{{ __('Your new API token is:') }}</p>
            <p class="font-mono bg-gray-800 text-white p-2 rounded mt-2">{{ session('token') }}</p>
        </div>
    @endif
@endsection
