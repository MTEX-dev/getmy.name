@extends('layouts.profile')

@section('header_content')
    {{ __('API Tokens') }}
@endsection

@section('content_inner')
<section class="space-y-10">
    <!-- Header -->
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('API Tokens') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Manage access tokens for third-party services.') }}</p>
        </div>
    </header>

    <!-- New Token Success Modal/Alert -->
    @if (session('status') === 'api-token-created')
        <div x-data="{ show: true }" x-show="show" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 relative">
            <div class="flex items-start gap-4">
                <div class="p-2 bg-green-100 dark:bg-green-800/50 rounded-full text-green-600 dark:text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-200">{{ __('Token Created Successfully') }}</h3>
                    <p class="mt-1 text-sm text-green-700 dark:text-green-300">{{ __('Please copy your new API token. For security reasons, it won\'t be shown again.') }}</p>
                    
                    <div class="mt-4 flex items-center gap-2">
                        <code class="block flex-1 p-3 bg-white dark:bg-gray-900 rounded-lg font-mono text-sm border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 break-all select-all">{{ session('token') }}</code>
                        <button 
                            x-data="{ copied: false }"
                            @click="navigator.clipboard.writeText('{{ session('token') }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-500 hover:text-getmyname-600 dark:hover:text-white transition-colors"
                            :title="copied ? 'Copied!' : 'Copy to clipboard'"
                        >
                            <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                            <svg x-show="copied" class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
        </div>
    @endif

    <div class="grid lg:grid-cols-2 gap-12">
        <!-- Create Token Form -->
        <div class="bg-gray-50 dark:bg-gray-900/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs">1</span>
                {{ __('Create New Token') }}
            </h3>

            <form method="POST" action="{{ route('profile.api-tokens.store') }}" class="space-y-5">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Token Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="e.g. My iOS App" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        {{ __('Permissions (Scopes)') }}
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($availableAbilities as $ability)
                            <label class="relative flex items-center p-3 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer bg-white dark:bg-gray-800 hover:border-getmyname-400 dark:hover:border-getmyname-500 transition-colors">
                                <input type="checkbox" name="abilities[]" value="{{ $ability }}" class="h-4 w-4 rounded border-gray-300 text-getmyname-600 focus:ring-getmyname-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($ability) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2">
                    <x-primary-button class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Generate Token') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Manage Tokens List -->
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs">2</span>
                {{ __('Active Tokens') }}
            </h3>

            @if ($tokens->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($tokens as $token)
                        <div class="group flex items-center justify-between p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-all">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-100 dark:bg-gray-900 rounded-lg text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $token->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        @if ($token->last_used_at)
                                            {{ __('Last used') }} <span class="font-medium text-getmyname-600 dark:text-getmyname-400">{{ $token->last_used_at->diffForHumans() }}</span>
                                        @else
                                            {{ __('Never used') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <form method="POST" action="{{ route('profile.api-tokens.destroy', $token->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this token?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg transition-colors" title="{{ __('Revoke Token') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-2xl">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No active tokens found.') }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection