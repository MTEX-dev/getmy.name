@extends('layouts.profile')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('profile.activity.title') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-5xl">
                    <header class="flex items-center gap-3 mb-8">
                        <div class="text-getmyname-600 dark:text-getmyname-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Recent Account Activity') }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('A log of changes made to your profile and settings.') }}
                            </p>
                        </div>
                    </header>

                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @forelse ($activity as $item)
                                <li>
                                    <div class="relative pb-8">
                                        @if (!$loop->last)
                                            <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-100 dark:bg-gray-700" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 dark:bg-gray-900 ring-8 ring-white dark:ring-gray-800">
                                                    @php
                                                        $icon = match($item->description) {
                                                            'created' => 'M12 4v16m8-8H4',
                                                            'updated' => 'M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z',
                                                            'deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                                                            default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                                        };
                                                    @endphp
                                                    <svg class="h-5 w-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 py-1.5">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-bold text-gray-900 dark:text-gray-100">
                                                        {{ ucfirst($item->description) }}
                                                    </span>
                                                    @if ($item->subject)
                                                        {{ strtolower(class_basename($item->subject_type)) }}
                                                    @endif
                                                    <span class="whitespace-nowrap ml-2 text-xs">{{ $item->created_at->diffForHumans() }}</span>
                                                </div>

                                                @if ($item->changes && isset($item->changes['attributes']))
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach ($item->changes['attributes'] as $key => $value)
                                                            @if(!in_array($key, ['password', 'remember_token']))
                                                                <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700">
                                                                    <span class="font-bold">{{ str_replace('_', ' ', $key) }}:</span>
                                                                    <span class="truncate max-w-[200px]">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('No activity yet') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Your profile change history will appear here.') }}</p>
                                </div>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-10">
                        {{ $activity->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection