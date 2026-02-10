@extends('layouts.profile')

@section('header_content')
    {{ __('profile.api_requests.title') }}
@endsection

@section('content_inner')
<section x-data="apiStatsHandler()">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-start justify-between gap-6 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('profile.api_requests.stats') }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('profile.api_requests.subtitle') }}</p>
            </div>
        </div>

        <!-- Range Controls -->
        <div class="inline-flex p-1.5 bg-gray-100 dark:bg-gray-800/80 rounded-xl self-start">
            <template x-for="range in ranges">
                <button 
                    @click="setRange(range.id)"
                    :class="currentRange === range.id 
                        ? 'bg-white dark:bg-gray-700 text-getmyname-600 dark:text-white shadow-sm ring-1 ring-black/5 dark:ring-white/5' 
                        : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-200/50 dark:hover:bg-gray-700/50'"
                    class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all duration-200"
                    x-text="range.label"
                ></button>
            </template>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-800/50 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Lifetime Requests') }}</p>
                <p class="mt-2 text-4xl font-black text-gray-900 dark:text-white tracking-tight" x-text="stats.total"></p>
            </div>
            <div class="absolute right-0 bottom-0 opacity-5 dark:opacity-10 transform translate-y-2 translate-x-2 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-800/50 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <p class="text-xs font-bold text-getmyname-500 uppercase tracking-widest">{{ __('Today') }}</p>
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-getmyname-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-getmyname-500"></span>
                    </span>
                </div>
                <p class="mt-2 text-4xl font-black text-gray-900 dark:text-white tracking-tight" x-text="stats.today"></p>
            </div>
        </div>
    </div>

    <!-- Chart Container -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm relative min-h-[400px]">
        <!-- Loading Overlay -->
        <div 
            x-show="loading" 
            x-transition.opacity
            class="absolute inset-0 bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm z-20 flex flex-col items-center justify-center rounded-2xl"
        >
            <svg class="animate-spin h-10 w-10 text-getmyname-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Fetching data...') }}</span>
        </div>

        <div class="h-[350px] w-full relative z-10">
            <canvas id="apiRequestsChart"></canvas>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script>
    function apiStatsHandler() {
        let chartInstance = null;
        let refreshInterval = null;

        return {
            currentRange: '30d',
            loading: true,
            stats: {
                total: {{ $stats['total'] }},
                today: {{ $stats['today'] }}
            },
            ranges: [
                { id: '1h', label: '1H', refresh: 60000 },
                { id: '24h', label: '24H', refresh: 300000 },
                { id: '7d', label: '7D', refresh: 600000 },
                { id: '30d', label: '30D', refresh: 3600000 },
                { id: '90d', label: '90D', refresh: 3600000 },
                { id: 'lifetime', label: 'ALL', refresh: 3600000 },
            ],
            
            init() {
                this.$nextTick(() => {
                    this.initChart();
                    this.fetchData(true);
                    this.setupAutoRefresh();
                });
            },

            setupAutoRefresh() {
                if (refreshInterval) clearInterval(refreshInterval);
                const range = this.ranges.find(r => r.id === this.currentRange);
                // Default fallback if range not found
                const refreshRate = range ? range.refresh : 300000; 
                refreshInterval = setInterval(() => {
                    this.fetchData(false);
                }, refreshRate);
            },

            initChart() {
                const canvas = document.getElementById('apiRequestsChart');
                if (!canvas) return;

                const isDarkMode = document.documentElement.classList.contains('dark');
                const ctx = canvas.getContext('2d');
                // You can pull this color from CSS variable if needed, simpler to hardcode matches
                const brandColor = '#10b981'; // emerald-500 matching getmyname-500 usually
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: { 
                        labels: [], 
                        datasets: [{ 
                            label: 'Requests',
                            data: [], 
                            borderColor: brandColor, 
                            backgroundColor: gradient,
                            fill: true, 
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: brandColor,
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
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
                                    title: function(context) {
                                        return context[0].label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { 
                                type: 'time', 
                                grid: { 
                                    display: false 
                                },
                                ticks: { 
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 8
                                } 
                            },
                            y: { 
                                beginAtZero: true,
                                border: { display: false },
                                grid: { 
                                    color: isDarkMode ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                                    drawBorder: false,
                                },
                                ticks: { 
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    precision: 0,
                                    padding: 10
                                } 
                            }
                        }
                    }
                });
            },

            setRange(rangeId) {
                if (this.loading) return;
                this.currentRange = rangeId;
                this.fetchData(true);
                this.setupAutoRefresh();
            },

            async fetchData(showLoader = false) {
                if (showLoader) this.loading = true;
                try {
                    const response = await fetch(`{{ route('profile.api-requests.data') }}?range=${this.currentRange}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const data = await response.json();

                    this.stats.total = data.stats.total;
                    this.stats.today = data.stats.today;

                    if (chartInstance) {
                        chartInstance.options.scales.x.time.unit = data.unit;
                        chartInstance.data.labels = data.labels;
                        chartInstance.data.datasets[0].data = data.counts;
                        chartInstance.update();
                    }
                } catch (error) {
                    console.error("Fetch Error:", error);
                } finally {
                    setTimeout(() => { this.loading = false; }, 300);
                }
            }
        }
    }
</script>
@endpush