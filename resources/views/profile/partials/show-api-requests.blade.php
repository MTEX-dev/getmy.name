@extends('layouts.profile')

@section('header_content')
    {{ __('profile.api_requests.title') }}
@endsection

@section('content_inner')
<section x-data="apiStatsHandler()">
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('profile.api_requests.stats') }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.api_requests.subtitle') }}</p>
            </div>
        </div>

        <!-- Timeframe Switcher -->
        <div class="inline-flex p-1 bg-gray-100 dark:bg-gray-800 rounded-xl">
            <template x-for="range in ranges">
                <button 
                    @click="setRange(range.id)"
                    :class="currentRange === range.id ? 'bg-white dark:bg-gray-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all"
                    x-text="range.label"
                ></button>
            </template>
        </div>
    </header>

    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-6 rounded-2xl shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Lifetime Requests</p>
            <p class="mt-2 text-3xl font-black text-gray-900 dark:text-gray-100">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-6 rounded-2xl shadow-sm">
            <p class="text-xs font-bold text-getmyname-500 uppercase tracking-widest">Today</p>
            <div class="flex items-center gap-3 mt-2">
                <p class="text-3xl font-black text-gray-900 dark:text-gray-100" id="today-count">{{ number_format($stats['today']) }}</p>
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-getmyname-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-getmyname-500"></span>
                </span>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="mt-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 shadow-sm relative">
        <div x-show="loading" class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-[1px] z-10 flex items-center justify-center rounded-2xl">
            <svg class="animate-spin h-8 w-8 text-getmyname-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
        <div class="h-80 w-full">
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
        return {
            currentRange: '30d',
            loading: false,
            chart: null,
            ranges: [
                { id: '1h', label: '1H' },
                { id: '24h', label: '24H' },
                { id: '7d', label: '7D' },
                { id: '30d', label: '30D' },
                { id: '90d', label: '90D' },
                { id: 'lifetime', label: 'ALL' },
            ],
            init() {
                this.initChart();
                this.fetchData();
                
                if (window.Echo) {
                    window.Echo.private(`user.${@json(auth()->id())}`)
                        .listen('ApiRequestProcessed', (e) => {
                            this.fetchData();
                        });
                }
            },
            initChart() {
                const isDarkMode = document.documentElement.classList.contains('dark');
                const ctx = document.getElementById('apiRequestsChart').getContext('2d');
                const brandColor = '#22c55e';
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(34, 197, 94, 0.15)');
                gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: { labels: [], datasets: [{ 
                        data: [], 
                        borderColor: brandColor, 
                        backgroundColor: gradient,
                        fill: true, 
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 2
                    }]},
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { 
                                type: 'time', 
                                grid: { display: false },
                                ticks: { color: isDarkMode ? '#9ca3af' : '#6b7280' } 
                            },
                            y: { 
                                beginAtZero: true,
                                grid: { color: isDarkMode ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                                ticks: { color: isDarkMode ? '#9ca3af' : '#6b7280' } 
                            }
                        }
                    }
                });
            },
            setRange(rangeId) {
                this.currentRange = rangeId;
                this.fetchData();
            },
            fetchData() {
                this.loading = true;
                fetch(`{{ route('profile.api-requests.data') }}?range=${this.currentRange}`)
                    .then(res => res.json())
                    .then(data => {
                        this.chart.options.scales.x.time.unit = data.unit;
                        this.chart.data.labels = data.labels;
                        this.chart.data.datasets[0].data = data.counts;
                        this.chart.update();
                        this.loading = false;
                    });
            }
        }
    }
</script>
@endpush