<section id="features" class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">{{ __('lander.features.section_title') }}</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">{{ __('lander.features.title') }}</p>
            <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">{{ __('lander.features.subtitle') }}</p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <i class="bi bi-code-slash text-white text-xl"></i>
                        </div>
                        {{ __('lander.features.api_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.features.api_description') }}
                    </dd>
                </div>
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <i class="bi bi-lock-fill text-white text-xl"></i>
                        </div>
                        {{ __('lander.features.secure_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.features.secure_description') }}
                    </dd>
                </div>
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <i class="bi bi-pencil-square text-white text-xl"></i>
                        </div>
                        {{ __('lander.features.management_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.features.management_description') }}
                    </dd>
                </div>
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <i class="bi bi-share-fill text-white text-xl"></i>
                        </div>
                        {{ __('lander.features.integration_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.features.integration_description') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</section>