@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Platform Intelligence
    </h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Side Navigation -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <nav class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Metrics Dashboard
                        </p>
                    </div>
                    <div class="p-3 space-y-1">
                        <a href="{{ route('stats.platform', ['metric' => 'api-requests']) }}" 
                           class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ $metric === 'api-requests' ? 'bg-gradient-to-r from-getmyname-500 to-getmyname-600 text-white shadow-lg shadow-getmyname-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:translate-x-1' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ $metric === 'api-requests' ? 'bg-white/20' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-getmyname-50 dark:group-hover:bg-getmyname-900/20' }} transition-colors">
                                <svg class="w-5 h-5 {{ $metric === 'api-requests' ? '' : 'text-getmyname-600 dark:text-getmyname-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span>API Requests</span>
                        </a>

                        <a href="{{ route('stats.platform', ['metric' => 'users']) }}" 
                           class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ $metric === 'users' ? 'bg-gradient-to-r from-getmyname-500 to-getmyname-600 text-white shadow-lg shadow-getmyname-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:translate-x-1' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ $metric === 'users' ? 'bg-white/20' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-getmyname-50 dark:group-hover:bg-getmyname-900/20' }} transition-colors">
                                <svg class="w-5 h-5 {{ $metric === 'users' ? '' : 'text-getmyname-600 dark:text-getmyname-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span>Users</span>
                        </a>
                    </div>
                </nav>

                <!-- Quick Info Card -->
                <div class="mt-6 bg-gradient-to-br from-getmyname-50 to-emerald-50 dark:from-getmyname-900/20 dark:to-emerald-900/20 rounded-2xl p-5 border border-getmyname-100 dark:border-getmyname-800">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-getmyname-500 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Live Updates</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                        Charts auto-refresh based on selected time range for real-time insights.
                    </p>
                </div>
            </aside>

            <!-- Main Chart Section -->
            <main class="flex-1 min-w-0" x-data="platformStatsHandler('{{ $metric }}')">
                
                <!-- Header & Controls -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-6 mb-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $meta['title'] }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $meta['desc'] }}</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <!-- Custom Inputs -->
                            <div x-show="currentRange === 'custom'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 class="flex flex-col sm:flex-row gap-2 items-stretch">
                                <input type="datetime-local" 
                                       x-model="customFrom" 
                                       class="px-3 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-getmyname-500 focus:ring-getmyname-500 rounded-lg shadow-sm">
                                <span class="text-gray-400 self-center hidden sm:block">→</span>
                                <input type="datetime-local" 
                                       x-model="customTo" 
                                       class="px-3 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-getmyname-500 focus:ring-getmyname-500 rounded-lg shadow-sm">
                                <button @click="fetchData(true)" 
                                        class="px-4 py-2 text-sm font-medium bg-getmyname-500 text-white rounded-lg hover:bg-getmyname-600 active:scale-95 transition-all shadow-sm hover:shadow-md">
                                    Apply
                                </button>
                            </div>

                            <!-- Range Toggles -->
                            <div class="inline-flex p-1.5 bg-gray-100 dark:bg-gray-700/50 rounded-xl overflow-x-auto shadow-inner border border-gray-200 dark:border-gray-600">
                                <template x-for="range in ranges">
                                    <button 
                                        @click="setRange(range.id)"
                                        :class="currentRange === range.id ? 'bg-white dark:bg-gray-600 shadow-md text-getmyname-600 dark:text-getmyname-400 font-semibold' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'"
                                        class="px-4 py-2 text-xs rounded-lg transition-all whitespace-nowrap"
                                        x-text="range.label"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <!-- Total Stats Card -->
                    <div class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-purple-500/5 rounded-full blur-2xl"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ $meta['total_label'] }}
                                </p>
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-4xl font-black text-gray-900 dark:text-gray-100 tracking-tight" x-text="stats.total.toLocaleString()"></p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">All time cumulative</p>
                        </div>
                    </div>

                    <!-- Today Stats Card -->
                    <div class="group bg-gradient-to-br from-getmyname-500 to-emerald-600 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-xs font-semibold text-white/90 uppercase tracking-wider">
                                    {{ $meta['today_label'] }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <span class="flex h-2 w-2 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                    </span>
                                    <span class="text-xs text-white/80 font-medium">Live</span>
                                </div>
                            </div>
                            <p class="text-4xl font-black text-white tracking-tight" x-text="stats.today.toLocaleString()"></p>
                            <p class="mt-2 text-xs text-white/80">Updated in real-time</p>
                        </div>
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 relative">
                    <!-- Loading Overlay -->
                    <div x-show="loading" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="animate-spin h-10 w-10 text-getmyname-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Loading data...</p>
                        </div>
                    </div>

                    <!-- Chart Header -->
                    <div class="mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Activity Timeline</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Historical data visualization</p>
                    </div>

                    <!-- Chart Canvas -->
                    <div class="h-96 w-full">
                        <canvas id="platformChart"></canvas>
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script>
    function platformStatsHandler(currentMetric) {
        let chartInstance = null;
        let refreshInterval = null;

        return {
            metric: currentMetric,
            currentRange: '30d',
            customFrom: '',
            customTo: '',
            loading: true,
            stats: {
                total: {{ $stats['total'] }},
                today: {{ $stats['today'] }}
            },
            ranges: [
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
                    this.observeDarkMode();
                });
            },

            observeDarkMode() {
                // Watch for dark mode changes
                const observer = new MutationObserver(() => {
                    this.updateChartTheme();
                });
                
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            },

            updateChartTheme() {
                if (!chartInstance) return;
                
                const isDarkMode = document.documentElement.classList.contains('dark') || 
                                   (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                // Update grid and text colors
                chartInstance.options.scales.x.ticks.color = isDarkMode ? '#9ca3af' : '#6b7280';
                chartInstance.options.scales.x.border.color = isDarkMode ? '#374151' : '#e5e7eb';
                chartInstance.options.scales.y.ticks.color = isDarkMode ? '#9ca3af' : '#6b7280';
                chartInstance.options.scales.y.grid.color = isDarkMode ? 'rgba(75, 85, 99, 0.2)' : 'rgba(229, 231, 235, 0.8)';
                
                // Update tooltip
                chartInstance.options.plugins.tooltip.backgroundColor = isDarkMode ? 'rgba(31, 41, 55, 0.95)' : 'rgba(255, 255, 255, 0.95)';
                chartInstance.options.plugins.tooltip.titleColor = isDarkMode ? '#f9fafb' : '#111827';
                chartInstance.options.plugins.tooltip.bodyColor = isDarkMode ? '#d1d5db' : '#374151';
                chartInstance.options.plugins.tooltip.borderColor = isDarkMode ? '#374151' : '#e5e7eb';
                
                chartInstance.update('none');
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
                const canvas = document.getElementById('platformChart');
                if (!canvas) return;

                const isDarkMode = document.documentElement.classList.contains('dark') || 
                                   (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
                const ctx = canvas.getContext('2d');
                const brandColor = '#22c55e';
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
                gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

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
                            borderWidth: 2.5,
                            pointRadius: 0,
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: brandColor,
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3,
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
                                backgroundColor: isDarkMode ? 'rgba(31, 41, 55, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                                titleColor: isDarkMode ? '#f9fafb' : '#111827',
                                bodyColor: isDarkMode ? '#d1d5db' : '#374151',
                                borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                            }
                        },
                        scales: {
                            x: { 
                                type: 'time',
                                grid: { display: false },
                                ticks: { 
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    font: { size: 11 }
                                },
                                border: {
                                    color: isDarkMode ? '#374151' : '#e5e7eb'
                                }
                            },
                            y: { 
                                beginAtZero: true,
                                grid: { 
                                    color: isDarkMode ? 'rgba(75, 85, 99, 0.2)' : 'rgba(229, 231, 235, 0.8)',
                                    drawBorder: false,
                                },
                                ticks: { 
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    precision: 0,
                                    font: { size: 11 },
                                    padding: 8,
                                },
                                border: {
                                    display: false
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

                let query = `?range=${this.currentRange}`;
                if (this.currentRange === 'custom') {
                    query += `&from=${this.customFrom}&to=${this.customTo}`;
                    this.updateUrl();
                }

                try {
                    // Dynamic URL construction based on metric
                    let baseUrl = "{{ route('stats.platform.data', ':metric') }}";
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