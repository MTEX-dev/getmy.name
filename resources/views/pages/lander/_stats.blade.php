<section 
    x-data="{ 
        shown: false,
        startCounter(target, duration) {
            let start = 0;
            const increment = target / (duration / 10);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    clearInterval(timer);
                    return target;
                }
                return Math.floor(start);
            }, 10);
        }
    }" 
    x-intersect.once="shown = true"
    class="bg-gray-100 dark:bg-gray-900 py-24 sm:py-32"
>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:max-w-none text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                {{ __('lander.stats.section_title') }}
            </h2>
            <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-400">
                {{ __('lander.stats.subtitle') }}
            </p>
        </div>

        <dl class="mt-16 grid grid-cols-1 gap-px overflow-hidden rounded-2xl bg-gray-200 dark:bg-gray-700 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => __('lander.stats.active_users'), 'value' => $stats_data['userCount'], 'suffix' => '+'],
                    ['label' => __('lander.stats.api_calls_made'), 'value' => $stats_data['apiCalls'], 'suffix' => '+'],
                    ['label' => __('lander.stats.days_online'), 'value' => $stats_data['daysOnline'], 'suffix' => ''],
                    ['label' => __('lander.stats.days_in_dev'), 'value' => $stats_data['daysInDev'], 'suffix' => ''],
                    ['label' => __('lander.stats.projects_added'), 'value' => $stats_data['projectCount'], 'suffix' => ''],
                    ['label' => __('lander.stats.skills_added'), 'value' => $stats_data['skillCount'], 'suffix' => ''],
                    ['label' => __('lander.stats.years_experience'), 'value' => 2, 'suffix' => '+'],
                    ['label' => __('lander.stats.avg_response_time'), 'value' => 150, 'suffix' => 'ms'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="flex flex-col bg-white p-8 dark:bg-gray-800 transition-all hover:bg-gray-50 dark:hover:bg-gray-750">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        {{ $stat['label'] }}
                    </dt>
                    <dd class="order-first text-4xl font-bold tracking-tight text-getmyname-600 dark:text-getmyname-400">
                        <span>{{ $stat['value'] }}</span>{{ $stat['suffix'] }}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>