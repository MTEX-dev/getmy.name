@extends('layouts.profile')

@section('header_content')
    {{ __('profile.api_requests.title') }}
@endsection

@section('content_inner')
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.api_requests.stats') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.api_requests.subtitle') }}
            </p>
        </header>

        <div class="mt-6">
            <div class="relative h-96">
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
            fetch('{{ route('profile.api-requests.data') }}')
                .then((response) => response.json())
                .then((data) => {
                    const ctx = document
                        .getElementById('apiRequestsChart')
                        .getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'API Requests',
                                    data: data.counts,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgb(75, 192, 192)',
                                    borderWidth: 1,
                                    fill: true,
                                    tension: 0.3,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'day',
                                        tooltipFormat: 'PPP',
                                        displayFormats: {
                                            day: 'MMM d',
                                        },
                                    },
                                    title: {
                                        display: true,
                                        text: 'Date',
                                    },
                                    ticks: {
                                        source: 'auto',
                                        autoSkip: true,
                                        maxRotation: 0,
                                        minRotation: 0,
                                    },
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Requests',
                                    },
                                    ticks: {
                                        precision: 0,
                                    },
                                },
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        color: 'rgb(156, 163, 175)',
                                    },
                                },
                                tooltip: {
                                    callbacks: {
                                        title: function (context) {
                                            const date = new Date(
                                                context[0].parsed.x
                                            );
                                            return date.toLocaleDateString(
                                                undefined,
                                                {
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric',
                                                }
                                            );
                                        },
                                        label: function (context) {
                                            return `Requests: ${context.raw}`;
                                        },
                                    },
                                },
                            },
                        },
                    });
                })
                .catch((error) =>
                    console.error('Error fetching API request data:', error)
                );
        });
    </script>
@endpush