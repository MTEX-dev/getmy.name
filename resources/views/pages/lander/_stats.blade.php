<section class="bg-gray-100 dark:bg-gray-800 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:max-w-none">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">
                    {{ __('lander.stats.section_title') }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    {{ __('lander.stats.subtitle') }}
                </p>
            </div>
            <dl
                class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4"
            >
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('lander.stats.active_users') }}
                    </dt>
                    <dd
                        class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100"
                    >
                        {{ App\Models\User::count() }}+
                    </dd>
                </div>
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('lander.stats.api_calls_made') }}
                    </dt>
                    <dd
                        class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100"
                    >
                        {{ App\Models\ApiRequest::count() }}+
                    </dd>
                </div>
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('lander.stats.days_online') }}
                    </dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">
                        {{  round(Carbon\Carbon::parse('2025-08-08')->diffInDays(Carbon\Carbon::now()))  }}+
                    </dd>
                </div>
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('lander.stats.years_experience') }}
                    </dt>
                    <dd
                        class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100"
                    >
                        2+
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</section>