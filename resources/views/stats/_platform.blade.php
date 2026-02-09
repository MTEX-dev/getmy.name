@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $meta['title'] }} Statistics
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <section x-data="statsHandler('{{ $metric }}')">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <div class="text-indigo-600 dark:text-indigo-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $meta['title'] }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $meta['desc'] }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 items-end sm:items-center">
                        <div x-show="currentRange === 'custom'" x-transition class="flex flex-col sm:flex-row gap-2">
                            <input type="datetime-local" x-model="customFrom" class="px-3 py-1.5 text-xs font-bold border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <span class="text-gray-400 self-center hidden sm:block">-</span>
                            <input type="datetime-local" x-model="customTo" class="px-3 py-1.5 text-xs font-bold border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <button @click="fetchData(true)" class="px-3 py-1.5 text-xs font-bold bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors">
                                Go
                            </button>
                        </div>

                        <div class="inline-flex p-1 bg-gray-100 dark:bg-gray-700 rounded-xl overflow-x-auto max-w-full">
                            <template x-for="range in ranges">
                                <button 
                                    @click="setRange(range.id)"
                                    :class="currentRange === range.id ? 'bg-white dark:bg-gray-600 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                                    class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap"
                                    x-text="range.label"
                                ></button>
                            </template>
                        </div>
                    </div>
                </header>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $meta['total_label'] }}</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-gray-100" x-text="stats.total"></p>
                </div>
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest">{{ $meta['today_label'] }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <p class="text-3xl font-black text-gray-900 dark:text-gray-100" x-text="stats.today"></p>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm relative">
                <div x-show="loading" class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-[1px] z-10 flex items-center justify-center rounded-2xl">
                    <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
                <div class="h-80 w-full">
                    <canvas id="statsChart"></canvas>
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
    function statsHandler(currentMetric) {
        let chartInstance = null;
        let refreshInterval = null;

        return {
            metric: currentMetric,
            currentRange: '30d',
            customFrom: '',
            customTo: '',
            loading: true,
            // Initial stats passed from Controller
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
                { id: 'custom', label: 'Custom', refresh: null },
            ],
            
            init() {
                // Initialize URL params
                const urlParams = new URLSearchParams(window.location.search);
                const urlRange = urlParams.get('range');
                const from = urlParams.get('from');
                const to = urlParams.get('to');

                if (urlRange) {
                    this.currentRange = urlRange;
                    if (this.currentRange === 'custom' && from && to) {
                        this.customFrom = from;
                        this.customTo = to;
                    }
                }
                
                // Set default custom dates if empty
                if (!this.customFrom) {
                    const now = new Date();
                    const yesterday = new Date(now);
                    yesterday.setDate(yesterday.getDate() - 1);
                    this.customTo = now.toISOString().slice(0, 16);
                    this.customFrom = yesterday.toISOString().slice(0, 16);
                }

                this.$nextTick(() => {
                    this.initChart();
                    this.fetchData(true);
                    this.setupAutoRefresh();
                });
            },

            setupAutoRefresh() {
                if (refreshInterval) clearInterval(refreshInterval);
                const range = this.ranges.find(r => r.id === this.currentRange);
                if (range && range.refresh && this.currentRange !== 'custom') {
                    refreshInterval = setInterval(() => {
                        this.fetchData(false);
                    }, range.refresh);
                }
            },

            initChart() {
                const canvas = document.getElementById('statsChart');
                if (!canvas) return;

                const isDarkMode = document.documentElement.classList.contains('dark') || 
                                   (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
                const ctx = canvas.getContext('2d');
                
                // You can customize color based on metric if desired
                const brandColor = '#6366f1'; // Indigo-500
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.15)'); // Indigo
                gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: { 
                        labels: [], 
                        datasets: [{ 
                            label: 'Count',
                            data: [], 
                            borderColor: brandColor, 
                            backgroundColor: gradient,
                            fill: true, 
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0,
                            pointHoverRadius: 6,
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
                                enabled: true,
                                position: 'nearest',
                            }
                        },
                        scales: {
                            x: { 
                                type: 'time', 
                                grid: { display: false },
                                ticks: { color: isDarkMode ? '#9ca3af' : '#6b7280' } 
                            },
                            y: { 
                                beginAtZero: true,
                                grid: { color: isDarkMode ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                                ticks: { 
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    precision: 0 
                                } 
                            }
                        }
                    }
                });
            },

            setRange(rangeId) {
                if (rangeId === 'custom' && this.currentRange !== 'custom') {
                    this.currentRange = rangeId;
                    return; 
                }

                if (this.loading) return;
                this.currentRange = rangeId;
                
                this.updateUrl();
                this.fetchData(true);
                this.setupAutoRefresh();
            },

            updateUrl() {
                const url = new URL(window.location);
                // Keep the current metric in the path, only update params
                url.searchParams.set('range', this.currentRange);
                if (this.currentRange === 'custom') {
                    url.searchParams.set('from', this.customFrom);
                    url.searchParams.set('to', this.customTo);
                } else {
                    url.searchParams.delete('from');
                    url.searchParams.delete('to');
                }
                window.history.pushState({}, '', url);
            },

            async fetchData(showLoader = false) {
                if (showLoader) this.loading = true;

                // Build Query Parameters
                let query = `?range=${this.currentRange}`;
                if (this.currentRange === 'custom') {
                    query += `&from=${this.customFrom}&to=${this.customTo}`;
                    this.updateUrl(); 
                }

                try {
                    // DYNAMIC URL GENERATION
                    // We generate the base route for the 'getData' endpoint, 
                    // replacing the placeholder ':metric' with the current js variable.
                    let baseUrl = "{{ route('stats.data', ':metric') }}";
                    let finalUrl = baseUrl.replace(':metric', this.metric);

                    const response = await fetch(finalUrl + query);
                    const data = await response.json();

                    // Update Alpine Stats
                    this.stats.total = data.stats.total;
                    this.stats.today = data.stats.today;

                    // Update Chart
                    if (chartInstance) {
                        chartInstance.options.scales.x.time.unit = data.unit;
                        chartInstance.data.labels = data.labels;
                        chartInstance.data.datasets[0].data = data.counts;
                        chartInstance.update('none');
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