@extends('layouts.profile')

@section('header_content')
    {{ __('profile.activity.title') }}
@endsection

@section('content_inner')
<section>
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Recent Activity') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('A log of changes made to your profile and settings.') }}
            </p>
        </div>
    </header>

    <div class="flow-root relative">
        <!-- Vertical Line -->
        <div class="absolute left-5 top-0 bottom-0 w-px bg-gray-200 dark:bg-gray-800 -z-10"></div>

        <ul role="list" class="-mb-8">
            @forelse ($activity as $item)
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex items-start space-x-4">
                            <!-- Timeline Dot -->
                            <div class="relative">
                                @php
                                    $iconConfig = match($item->description) {
                                        'created' => ['icon' => 'M12 4v16m8-8H4', 'bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-600 dark:text-emerald-400'],
                                        'updated' => ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99', 'bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400'],
                                        'deleted' => ['icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'bg' => 'bg-rose-100 dark:bg-rose-900/30', 'text' => 'text-rose-600 dark:text-rose-400'],
                                        default   => ['icon' => 'M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5', 'bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-500 dark:text-gray-400'],
                                    };
                                @endphp
                                <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $iconConfig['bg'] }} ring-8 ring-white dark:ring-gray-800 z-10">
                                    <svg class="h-5 w-5 {{ $iconConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconConfig['icon'] }}" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="min-w-0 flex-1 pt-1.5">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-2">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ ucfirst($item->description) }} 
                                        @if ($item->subject)
                                            <span class="font-normal text-gray-500 dark:text-gray-400">
                                                {{ strtolower(class_basename($item->subject_type)) }}
                                            </span>
                                        @endif
                                    </h4>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 font-medium whitespace-nowrap">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                @if ($item->changes && isset($item->changes['attributes']))
                                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($item->changes['attributes'] as $key => $value)
                                                @if(!in_array($key, ['password', 'remember_token', 'updated_at', 'created_at']))
                                                    <div class="inline-flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 px-2 py-1 rounded-md border border-gray-200 dark:border-gray-700 shadow-sm">
                                                        <span class="font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-[10px]">{{ str_replace('_', ' ', $key) }}:</span>
                                                        <span class="truncate max-w-[150px] font-mono">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <div class="py-12 flex flex-col items-center justify-center text-center">
                    <div class="p-4 rounded-full bg-gray-50 dark:bg-gray-900/50 mb-3">
                        <svg class="h-8 w-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('No activity recorded') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-sm">{{ __('Actions you perform on your profile will appear here in chronological order.') }}</p>
                </div>
            @endforelse
        </ul>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
        {{ $activity->links() }}
    </div>
</section>
@endsection