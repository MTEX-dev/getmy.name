<footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:justify-between md:items-center">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center md:justify-start">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'getmy.name') }}. All rights reserved.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3 text-center md:text-left">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Resources</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Dashboard</a>
                        </li>
                        {{-- <li>
                            <a href="#" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">API Documentation</a>
                        </li> --}}
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Company</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ url('/about') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">About</a>
                        </li>
                        <li>
                            <a href="{{ url('/contact') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Contact</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">More</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="https://fternis.de" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Fabian Ternis</a>
                        </li>
                        <li>
                            <a href="https://michaelninder.de" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Michaelninder</a>
                        </li>
                        <li>
                            <a href="https://xpsystems.eu" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">xpsystems.eu</a>
                        </li>
                        <li>
                            <a href="https://europehost.eu" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">EuropeHost.eu</a>
                        </li>
                        <li>
                            <a href="https://mtex.dev" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">mtex.dev</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>