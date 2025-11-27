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
                <div class="max-w-full">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('profile.activity.title') }}
                    </h3>

                    <div class="mt-6 space-y-6">
                        @forelse ($activity as $item)
                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    <span class="font-semibold">{{ $item->description }}</span>
                                    @if ($item->subject)
                                        on {{ $item->subject->getTable() }} (ID: {{ $item->subject->id }})
                                    @endif
                                    <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </p>
                                @if ($item->changes && $item->changes->has('attributes'))
                                    <div class="mt-2 text-xs text-gray-600 dark:text-gray-300">
                                        <p class="font-semibold">Changes:</p>
                                        <ul class="list-disc list-inside">
                                            @foreach ($item->changes['attributes'] as $key => $value)
                                                <li>{{ $key }}: {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No activity yet.</p>
                        @endforelse

                        <div class="mt-4">
                            {{ $activity->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
