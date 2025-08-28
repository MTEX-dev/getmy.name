<section class="bg-gray-100 dark:bg-gray-800 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:max-w-none">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">
                    Built on Trust & Innovation
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Reliable infrastructure by mtex.dev, designed for developers.
                </p>
            </div>
            <dl
                class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4"
            >
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        Active Users
                    </dt>
                    <dd
                        class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100"
                    >
                        {{ App\Models\User::count() }}+
                    </dd>
                </div>
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        API Calls made
                    </dt>
                    <dd
                        class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100"
                    >
                        {{ App\Models\ApiRequest::count() }}+
                    </dd>
                </div>
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        Days Online
                    </dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">
                        {{  round(Carbon\Carbon::parse('2025-08-08')->diffInDays(Carbon\Carbon::now()))  }}+
                    </dd>
                </div>
                <div class="flex flex-col bg-white/50 p-8 dark:bg-gray-700/50">
                    <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">
                        Years of Experience (mtex.dev)
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