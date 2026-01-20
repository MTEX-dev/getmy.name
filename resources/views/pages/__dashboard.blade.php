@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Analytics Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Real-time insights for your developer profile.') }}</p>
        </div>

        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2 bg-white dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            @foreach(['7' => '7D', '30' => '30D', '90' => '90D'] as $val => $label)
                <button type="submit" name="days" value="{{ $val }}" 
                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $days == $val ? 'bg-getmyname-500 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </form>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-getmyname-50 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-md">+{{ number_format($dates->last()['count']) }} today</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Requests') }}</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format(auth()->user()->getApiRequestCount()) }}</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Avg. Requests/Day') }}</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($dates->avg('count'), 1) }}</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Profile Health') }}</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100">98%</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-getmyname-50 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Last Request') }}</p>
                <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">
                    {{ \Carbon\Carbon::parse(auth()->user()->hasMany(\App\Models\ApiRequest::class)->latest('requested_at')->first()?->requested_at)->diffForHumans() ?? 'Never' }}
                </h4>
            </div>
        </div>

        <!-- Main Chart Section -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">
            <div class="p-8 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Traffic Trends') }}</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-getmyname-500"></span>
                            <span class="text-xs font-medium text-gray-500 uppercase">{{ __('API Calls') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-8 relative h-80">
                    <canvas id="requestsChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100 dark:divide-gray-700">
                <div class="p-6">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">{{ __('Top Endpoint') }}</p>
                    <p class="text-sm font-mono text-gray-700 dark:text-gray-300 truncate">{{ $topRoutes->first()->request_url ?? '/' }}</p>
                </div>
                <div class="p-6">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">{{ __('Preferred Method') }}</p>
                    <p class="text-sm font-bold text-getmyname-600">{{ $methodStats->sortByDesc('count')->first()->request_method ?? 'GET' }}</p>
                </div>
                <div class="p-6">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">{{ __('Current Template') }}</p>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ ucfirst(auth()->user()->template) }}</p>
                </div>
            </div>
        </div>

        <!-- Bottom Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Distribution -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-8">{{ __('Request Distribution') }}</h3>
                <div class="grid grid-cols-2 gap-8 items-center">
                    <div class="relative h-48">
                        <canvas id="methodsChart"></canvas>
                    </div>
                    <div class="space-y-4">
                        @foreach($methodStats as $stat)
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $stat->request_method }}</span>
                                <span class="text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $stat->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Profile Summary -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6">{{ __('Profile Overview') }}</h3>
                <div class="flex items-center gap-6 mb-8">
                    <img src="{{ auth()->user()->avatar() }}" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-getmyname-50 dark:ring-getmyname-900/20">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</h4>
                        <p class="text-sm text-getmyname-600 dark:text-getmyname-400 font-medium">{{ auth()->user()->title ?? 'No title set' }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                        <p class="text-xs font-bold text-gray-400 uppercase">{{ __('Projects') }}</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ auth()->user()->projects()->count() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                        <p class="text-xs font-bold text-gray-400 uppercase">{{ __('Skills') }}</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ auth()->user()->skills()->count() }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('profile.edit') }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition-all">
                        {{ __('Edit Profile Details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const primaryColor = '#22c55e';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
    const textColor = isDark ? '#9ca3af' : '#6b7280';

    // Traffic Chart
    new Chart(document.getElementById('requestsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dates->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))) !!},
            datasets: [{
                data: {!! json_encode($dates->pluck('count')) !!},
                borderColor: primaryColor,
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: primaryColor,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3,
                fill: true,
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
                    gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');
                    return gradient;
                },
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: textColor, font: { size: 11, weight: 'bold' } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } }
            }
        }
    });

    // Methods Pie Chart
    new Chart(document.getElementById('methodsChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($methodStats->pluck('request_method')) !!},
            datasets: [{
                data: {!! json_encode($methodStats->pluck('count')) !!},
                backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection