<section class="relative isolate overflow-hidden bg-gradient-to-b from-getmyname-100/20 pt-28 dark:from-getmyname-900/20 sm:pt-36 lg:pt-44">
    <div class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white shadow-xl shadow-getmyname-600/10 ring-1 ring-getmyname-50 dark:bg-gray-800 dark:shadow-getmyname-900/10 dark:ring-getmyname-900 sm:-mr-80 lg:-mr-96" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-6 pt-12 pb-36 sm:pt-20 sm:pb-44 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0">
            <h2 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-6xl">{{ __('lander.hero.title') }}</h2>
            <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                {{ __('lander.hero.subtitle') }}
            </p>
            <p class="mt-4 text-md leading-7 text-gray-500 dark:text-gray-500">
                {{ __('lander.hero.crafted_by') }} <a href="https://mtex.dev" target="_blank" class="text-getmyname-600 dark:text-getmyname-400 hover:underline">mtex.dev</a>.
            </p>
            <div class="mt-10 flex items-center gap-x-6">
                <a href="{{ route('register') }}" class="rounded-md bg-getmyname-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-getmyname-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-getmyname-600">
                    {{ __('lander.hero.guest_cta_btn') }}
                </a>
                <a href="#features" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100">
                    {{ __('lander.hero.learn_more_cta') }} <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-gray-50 dark:from-gray-900 sm:h-32"></div>
</section>