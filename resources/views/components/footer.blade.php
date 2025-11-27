<footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="text-center md:text-left">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center md:justify-start">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'getmy.name') }}. All rights reserved.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    {{ __('Resources') }}
                </h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('lander') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">{{ __('strings.dashboard') }}</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">{{ __('profile.profile') }}</a></li>
                    <li><a href="{{ route('sitemap') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">{{ __('sitemap.sitemap') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    {{ __('Other Projects by') }} <a href="https://mtex.dev" target="_blank" class="hover:underline">mtex.dev</a>
                </h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="https://gimy.site" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            gimy.site <span class="text-xs text-getmyname-500">({{ __('Free static webhosting') }})</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-center sm:justify-between items-center text-sm text-gray-500 dark:text-gray-400 space-y-4 sm:space-y-0">
            <div>
                {{ __('Built with') }} ❤️ {{ __('by') }} <a href="https://mtex.dev" class="hover:underline" target="_blank">mtex.dev</a>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('legal', 'imprint') }}" class="hover:underline">{{ __('legal.imprint.title') }}</a>
                <a href="{{ route('legal', 'privacy') }}" class="hover:underline">{{ __('legal.privacy.title') }}</a>
                <a href="{{ route('legal', 'terms') }}" class="hover:underline">{{ __('legal.terms.title') }}</a>
            </div>
        </div>
    </div>
</footer>