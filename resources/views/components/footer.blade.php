<footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Logo & Company Info -->
            <div class="text-center md:text-left">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center md:justify-start">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'getmy.name') }}. All rights reserved.
                </p>
            </div>

            <!-- Resources -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Resources</h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Company Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Company</h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ url('/about') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            About
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Other Projects -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    Other Projects by <a href="https://mtex.dev" target="_blank" class="hover:underline">mtex.dev</a>
                </h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="https://gimy.site" target="_blank" class="text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            gimy.site <span class="text-xs text-indigo-500">(Free static hosting)</span>
                        </a>
                    </li>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Divider -->
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Built with ❤️ by <a href="https://mtex.dev" class="hover:underline" target="_blank">mtex.dev</a>
        </div>
    </div>
</footer>
