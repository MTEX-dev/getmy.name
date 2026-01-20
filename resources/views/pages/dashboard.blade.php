@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Welcome back,') }} {{ auth()->user()->name }}!</p>
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
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-getmyname-50 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-md">+{{ number_format($dates->last()['count']) }}</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Requests') }}</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format(auth()->user()->getApiRequestCount()) }}</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Avg. Requests/Day') }}</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($dates->avg('count'), 1) }}</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Top Endpoint') }}</p>
                <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mt-1 truncate">{{ $topRoutes->first()->request_url ?? '/' }}</h4>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-getmyname-50 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Last Request') }}</p>
                <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mt-1 truncate">
                    {{ \Carbon\Carbon::parse(auth()->user()->hasMany(\App\Models\ApiRequest::class)->latest('requested_at')->first()?->requested_at)->diffForHumans() ?? 'Never' }}
                </h4>
            </div>
        </div>

        <!-- Main Chart Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-getmyname-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                            {{ __('Activity Overview') }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Last :days days', ['days' => $days]) }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="relative h-80">
                    <canvas id="requestsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Methods Distribution -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        {{ __('Request Methods') }}
                    </h3>
                </div>
                <div class="flex justify-center">
                    <div class="relative w-full max-w-xs h-64">
                        <canvas id="methodsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Routes -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        {{ __('Top Routes') }}
                    </h3>
                </div>
                <div class="flex justify-center">
                    <div class="relative w-full max-w-xs h-64">
                        <canvas id="routesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    {{ __('Detailed Route Statistics') }}
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Route Endpoint') }}
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Total Requests') }}
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Percentage') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($topRoutes as $route)
                            @php
                                $totalReqs = $topRoutes->sum('count');
                                $percentage = $totalReqs > 0 ? ($route->count / $totalReqs) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-getmyname-500"></span>
                                        {{ $route->request_url }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 text-right font-mono">
                                    {{ number_format($route->count) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="text-xs">{{ number_format($percentage, 1) }}%</span>
                                        <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                            <div class="bg-getmyname-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-getmyname-600 to-getmyname-800 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-black/10 rounded-full blur-xl"></div>
            
            <div class="relative z-10">
                <h3 class="text-xl font-bold mb-2">{{ __('Quick Actions') }}</h3>
                <p class="text-getmyname-100 text-sm mb-6">{{ __('Manage your profile and test your API endpoint') }}</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white text-getmyname-700 text-sm font-bold rounded-lg shadow-sm hover:bg-getmyname-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        {{ __('Manage Profile') }}
                    </a>
                    <a href="{{ route('profile.get.data', ['username' => Auth::user()->username]) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-getmyname-700/50 text-white text-sm font-bold rounded-lg hover:bg-getmyname-700/70 border border-white/20 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                        {{ __('Test JSON Request') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#9ca3af' : '#6b7280';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
    
    // Brand Colors
    const primaryColor = '#22c55e';
    const primaryBg = 'rgba(34, 197, 94, 0.1)';

    // Main Line Chart
    new Chart(document.getElementById('requestsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dates->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('M j'))) !!},
            datasets: [{
                label: '{{ __("API Requests") }}',
                data: {!! json_encode($dates->pluck('count')) !!},
                borderColor: primaryColor,
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 320);
                    gradient.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
                    gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');
                    return gradient;
                },
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: primaryColor,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    titleColor: isDark ? '#f3f4f6' : '#111827',
                    bodyColor: isDark ? '#d1d5db' : '#4b5563',
                    borderColor: gridColor,
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    ticks: { color: textColor, font: { size: 11, weight: 'bold' } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: textColor, precision: 0 },
                    grid: { color: gridColor, borderDash: [2, 2] }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
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
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        color: textColor,
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 11 }
                    }
                }
            },
            cutout: '65%'
        }
    });

    // Routes Doughnut Chart
    new Chart(document.getElementById('routesChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($topRoutes->pluck('request_url')->map(fn($url) => strlen($url) > 25 ? '...' . substr($url, -22) : $url)) !!},
            datasets: [{
                data: {!! json_encode($topRoutes->pluck('count')) !!},
                backgroundColor: [
                    '#22c55e', '#16a34a', '#15803d', '#3b82f6', '#06b6d4',
                    '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        color: textColor,
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 11 }
                    }
                }
            },
            cutout: '65%'
        }
    });
</script>
@endsection