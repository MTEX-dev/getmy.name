@extends('layouts.profile')

@section('header_content')
    {{ __('profile.api_requests.title') }}
@endsection

@section('content_inner')
    <section>
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

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-5 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                    {{ __('profile.api_requests.total_lifetime') ?? 'Lifetime Total' }}
                </p>
                <p class="mt-2 text-3xl font-black text-gray-900 dark:text-gray-100">
                    {{ number_format($stats['total']) }}
                </p>
            </div>

            <div class="p-5 rounded-2xl border border-getmyname-100 dark:border-getmyname-900/30 bg-getmyname-50/30 dark:bg-getmyname-900/10 shadow-sm">
                <p class="text-xs font-bold text-getmyname-700 dark:text-getmyname-400 uppercase tracking-widest">
                    {{ __('profile.api_requests.last_30_days') ?? 'Last 30 Days' }}
                </p>
                <p class="mt-2 text-3xl font-black text-getmyname-600 dark:text-getmyname-500">
                    {{ number_format($stats['month']) }}
                </p>
            </div>

            <div class="p-5 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                    {{ __('profile.api_requests.today') ?? 'Today' }}
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <p class="text-3xl font-black text-gray-900 dark:text-gray-100">
                        {{ number_format($stats['today']) }}
                    </p>
                    @if($stats['today'] > 0)
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-getmyname-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-getmyname-500"></span>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ __('profile.api_requests.usage_history') ?? 'Usage History' }}</h3>
                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium bg-gray-50 dark:bg-gray-800 px-3 py-1 rounded-full border border-gray-100 dark:border-gray-700">
                    Showing last 30 days
                </div>
            </div>
            <div class="p-6">
                <div class="relative h-80 w-full">
                    <canvas id="apiRequestsChart"></canvas>
                </div>
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
            
            const brandColor = '#22c55e'; 
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            const textColor = isDarkMode ? '#9ca3af' : '#6b7280';

            fetch('{{ route('profile.api-requests.data') }}')
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('apiRequestsChart').getContext('2d');
                    
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(34, 197, 94, 0.15)');
                    gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Requests',
                                data: data.counts,
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: brandColor,
                                borderWidth: 3,
                                pointRadius: 0,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: brandColor,
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { intersect: false, mode: 'index' },
                            scales: {
                                x: {
                                    type: 'time',
                                    time: { unit: 'day', displayFormats: { day: 'MMM d' } },
                                    grid: { display: false },
                                    ticks: { color: textColor, font: { size: 11, weight: '500' } }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: { color: gridColor, borderDash: [5, 5] },
                                    ticks: { precision: 0, color: textColor, font: { size: 11 } }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    padding: 12,
                                    backgroundColor: isDarkMode ? '#111827' : '#ffffff',
                                    titleColor: isDarkMode ? '#f3f4f6' : '#111827',
                                    titleFont: { size: 13, weight: 'bold' },
                                    bodyColor: isDarkMode ? '#9ca3af' : '#4b5563',
                                    borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                                    borderWidth: 1,
                                    displayColors: false,
                                    callbacks: {
                                        title: (context) => {
                                            const d = new Date(context[0].parsed.x);
                                            return d.toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' });
                                        },
                                        label: (context) => `Requests: ${context.raw}`
                                    }
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endpush