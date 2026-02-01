@extends('layouts.profile')

@section('header_content')
    {{ __('profile.api_requests.title') }}
@endsection

@section('content_inner')
    <section>
        <!-- Header -->
        <header>
            <div class="flex items-center gap-3">
                <div class="text-getmyname-600 dark:text-getmyname-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('profile.api_requests.stats') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('profile.api_requests.subtitle') }}
                    </p>
                </div>
            </div>
        </header>

        <!-- Summary Cards -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Total Requests -->
            <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('profile.api_requests.total_lifetime') ?? 'Lifetime Requests' }}
                </p>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ number_format($stats['total']) }}
                </p>
            </div>

            <!-- Last 30 Days -->
            <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        {{ __('profile.api_requests.last_30_days') ?? 'Last 30 Days' }}
                    </p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                        Active
                    </span>
                </div>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ number_format($stats['month']) }}
                </p>
            </div>

            <!-- Today -->
            <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('profile.api_requests.today') ?? 'Requests Today' }}
                </p>
                <div class="flex items-baseline gap-2">
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ number_format($stats['today']) }}
                    </p>
                    @if($stats['today'] > 0)
                        <span class="text-xs text-getmyname-600 dark:text-getmyname-400 animate-pulse">
                            ● Live
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="mt-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">
                    {{ __('profile.api_requests.traffic_overview') ?? 'Traffic Overview' }}
                </h3>
                <!-- Simple Time Range Indicator -->
                <div class="flex bg-gray-100 dark:bg-gray-800 rounded-lg p-1 text-xs font-medium">
                    <button class="px-3 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm rounded-md">30 Days</button>
                    <button class="px-3 py-1 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 cursor-not-allowed opacity-50" disabled>7 Days</button>
                    <button class="px-3 py-1 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 cursor-not-allowed opacity-50" disabled>24 Hours</button>
                </div>
            </div>

            <div class="relative h-80 w-full">
                <canvas id="apiRequestsChart"></canvas>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDarkMode = document.documentElement.classList.contains('dark');
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            const textColor = isDarkMode ? '#9ca3af' : '#6b7280';
            
            const primaryColor = '#4f46e5'; 

            fetch('{{ route('profile.api-requests.data') }}')
                .then((response) => response.json())
                .then((data) => {
                    const ctx = document.getElementById('apiRequestsChart').getContext('2d');
                    
                    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Requests',
                                data: data.counts,
                                backgroundColor: gradient,
                                borderColor: primaryColor,
                                borderWidth: 2,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: primaryColor,
                                pointBorderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                fill: true,
                                tension: 0.4,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'day',
                                        displayFormats: { day: 'MMM d' },
                                    },
                                    grid: {
                                        display: false,
                                    },
                                    ticks: {
                                        color: textColor,
                                        font: { size: 11 }
                                    },
                                    border: { display: false }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: gridColor,
                                        borderDash: [5, 5],
                                    },
                                    ticks: {
                                        precision: 0,
                                        color: textColor,
                                        font: { size: 11 }
                                    },
                                    border: { display: false }
                                },
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: isDarkMode ? '#1f2937' : '#ffffff',
                                    titleColor: isDarkMode ? '#f3f4f6' : '#111827',
                                    bodyColor: isDarkMode ? '#d1d5db' : '#4b5563',
                                    borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 10,
                                    displayColors: false,
                                    callbacks: {
                                        title: function (context) {
                                            const date = new Date(context[0].parsed.x);
                                            return date.toLocaleDateString(undefined, {
                                                weekday: 'short',
                                                month: 'short', 
                                                day: 'numeric'
                                            });
                                        },
                                        label: function (context) {
                                            return `${context.raw} Requests`;
                                        }
                                    }
                                }
                            },
                        },
                    });
                })
                .catch((error) => console.error('Error fetching API request data:', error));
        });
    </script>
@endpush