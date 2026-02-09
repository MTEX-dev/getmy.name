@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $stats['isPublic'] ? 'Platform Statistics' : __('profile.api_requests.title') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <section x-data="apiStatsHandler({{ $stats['isPublic'] ? 'true' : 'false' }})" class="space-y-6">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-getmyname-50 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600 dark:text-getmyname-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $stats['isPublic'] ? 'Global API Activity' : 'Your API Activity' }}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $stats['isPublic'] ? 'Real-time platform usage statistics' : 'Monitor your personal integration usage' }}
                            </p>
                        </div>
                    </div>

                    <div class="inline-flex p-1 bg-gray-100 dark:bg-gray-700/50 rounded-xl overflow-x-auto">
                        <template x-for="range in ranges">
                            <button 
                                @click="setRange(range.id)"
                                :class="currentRange === range.id ? 'bg-white dark:bg-gray-600 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                                class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap"
                                x-text="range.label"
                            ></button>
                        </template>
                    </div>
                </header>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Requests</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-gray-100" x-text="stats.total"></p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-bold text-getmyname-500 uppercase tracking-widest">In Last 24h</p>
                    <div class="flex items-center gap-3 mt-2">
                        <p class="text-3xl font-black text-gray-900 dark:text-gray-100" x-text="stats.today"></p>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-getmyname-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-getmyname-500"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm relative border border-gray-100 dark:border-gray-700">
                <div x-show="loading" class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-[1px] z-10 flex items-center justify-center rounded-2xl">
                    <svg class="animate-spin h-8 w-8 text-getmyname-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
                <div class="h-96 w-full">
                    <canvas id="apiRequestsChart"></canvas>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script>
    function apiStatsHandler(isPublic = false) {
        let chartInstance = null;
        let refreshInterval = null;
        const brandColor = '#22c55e'; // getmyname-500

        return {
            isPublic: isPublic,
            currentRange: '30d',
            loading: true,
            stats: { total: 0, today: 0 },
            ranges: [
                { id: '1h', label: '1H', refresh: 60000 },
                { id: '24h', label: '24H', refresh: 300000 },
                { id: '7d', label: '7D', refresh: 600000 },
                { id: '30d', label: '30D', refresh: 3600000 },
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
                if (range?.refresh) {
                    refreshInterval = setInterval(() => this.fetchData(false), range.refresh);
                }
            },

            initChart() {
                const ctx = document.getElementById('apiRequestsChart').getContext('2d');
                const isDarkMode = document.documentElement.classList.contains('dark');
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
                gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: { labels: [], datasets: [{ 
                        data: [], 
                        borderColor: brandColor, 
                        backgroundColor: gradient,
                        fill: true, tension: 0.4, borderWidth: 3, pointRadius: 0 
                    }]},
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { type: 'time', grid: { display: false }, ticks: { color: '#9ca3af' } },
                            y: { beginAtZero: true, grid: { color: isDarkMode ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' } }
                        }
                    }
                });
            },

            setRange(id) {
                this.currentRange = id;
                this.fetchData(true);
                this.setupAutoRefresh();
            },

            async fetchData(showLoader = false) {
                if (showLoader) this.loading = true;
                
                const endpoint = this.isPublic 
                    ? "{{ route('stats.public.data') }}" 
                    : "{{ route('stats.data') }}"; // Points to stats.data now
                
                const url = `${endpoint}?range=${this.currentRange}&global=${this.isPublic}`;
                
                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    
                    this.stats = data.stats;
                    if (chartInstance) {
                        chartInstance.options.scales.x.time.unit = data.unit;
                        chartInstance.data.labels = data.labels;
                        chartInstance.data.datasets[0].data = data.counts;
                        chartInstance.update();
                    }
                } catch (error) {
                    console.error("Fetch Error:", error);
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endpush