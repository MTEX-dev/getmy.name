<section id="get-started" class="bg-white dark:bg-gray-800 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="relative isolate overflow-hidden bg-gray-900 dark:bg-getmyname-900 px-6 py-24 shadow-2xl rounded-3xl sm:px-24 xl:py-32">
            <h2 class="mx-auto max-w-2xl text-center text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('lander.cta_banner.title') }}</h2>
            <p class="mx-auto mt-2 max-w-xl text-center text-lg leading-8 text-gray-300 dark:text-getmyname-200">
                {{ __('lander.cta_banner.subtitle') }}
            </p>
            <div class="mx-auto mt-10 flex max-w-md items-center justify-center gap-x-6">
                <a href="{{ route('register') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    {{ __('lander.cta_banner.signup_btn') }}
                </a>
                <a href="https://mtex.dev" target="_blank" class="text-sm font-semibold leading-6 text-white dark:text-getmyname-100">
                    {{ __('lander.cta_banner.learn_mtex_btn') }} <span aria-hidden="true">→</span>
                </a>
            </div>
            <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]" aria-hidden="true">
                <circle cx="512" cy="512" r="512" fill="url(#827591b1-ce8c-4110-b064-7cb857a09341)" fill-opacity="0.7" />
                <defs>
                    <radialGradient id="827591b1-ce8c-4110-b064-7cb857a09341">
                        <stop stop-color="#16a34a" />
                        <stop offset="1" stop-color="#86efac" />
                    </radialGradient>
                </defs>
            </svg>
        </div>
    </div>
</section>