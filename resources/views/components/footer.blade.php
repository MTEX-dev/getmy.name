<footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">

            <!-- Brand & Status -->
            <div class="flex flex-col items-center md:items-start">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 text-center md:text-left">
                    &copy; {{ '2025 - ' . date('Y') }} {{ config('app.name', 'getmy.name') }}.
                </p>
                <div class="mt-4 flex flex-col space-y-2">
                    <a href="https://gh.mtex.dev/getmy.name" target="_blank" class="inline-flex items-center text-xs text-gray-500 hover:text-gray-900 dark:hover:text-gray-100">
                        <span class="mr-2">GitHub:</span> gh.mtex.dev/getmy.name
                    </a>
                    <a href="https://status.mtex.dev" target="_blank" class="inline-flex items-center text-xs text-gray-500 hover:text-gray-900 dark:hover:text-gray-100">
                        <span class="mr-2">Status:</span> status.mtex.dev
                    </a>
                </div>
            </div>

            <!-- Internal Resources -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    {{ __('Resources') }}
                </h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('lander') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">{{ __('strings.dashboard') }}</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">{{ __('profile.profile') }}</a></li>
                    <li><a href="{{ route('sitemap') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">{{ __('sitemap.sitemap') }}</a></li>
                    <li><a href="{{ route('stats.platform', ['metric' =>'api-requests']) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">{{ __('stats.platform') }}</a></li>
                </ul>
            </div>

            <!-- MTEX Ecosystem -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    {{ __('Projects by') }} <a href="https://mtex.dev" target="_blank" class="hover:underline">mtex.dev</a>
                </h3>
                <ul class="mt-4 space-y-4">
                    <li>
                        <a href="https://github.mtex.dev" target="_blank" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 block">
                            <span class="font-medium">github.mtex.dev</span>
                            <span class="block text-xs opacity-75">Open Source Contributions</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://tw.mtex.dev" target="_blank" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 block">
                            <span class="font-medium">tw.mtex.dev</span>
                            <span class="block text-xs opacity-75">Tailwind Components Library</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://diff.mtex.dev" target="_blank" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 block">
                            <span class="font-medium">diff.mtex.dev</span>
                            <span class="block text-xs opacity-75">Visual JSON Comparison Tool</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Specialized Services -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    {{ __('Network & Partners') }}
                </h3>
                <ul class="mt-4 space-y-4">
                    <li>
                        <a href="https://nx.mtex.dev" target="_blank" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 block">
                            <span class="font-medium">nx.mtex.dev</span>
                            <span class="block text-xs opacity-75 leading-relaxed">JSON API gateway for seamless data exchange and rapid prototyping.</span>
                        </a>
                    </li>
                    <li class="pt-2 border-t border-gray-200 dark:border-gray-700">
                        <a href="https://api-sandbox.de" target="_blank" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 block">
                            <span class="font-medium">api-sandbox.de</span>
                            <span class="block text-xs opacity-75 leading-relaxed italic text-indigo-500 dark:text-indigo-400">Ready-to-use REST API für deine nächsten Prototypen.</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 dark:text-gray-400 space-y-4 md:space-y-0">
            <div>
                {{ __('Built with') }} ❤️ {{ __('by') }} 
                <a href="https://mtex.dev" class="font-medium hover:text-gray-900 dark:hover:text-white transition-colors" target="_blank">mtex.dev</a>
            </div>
            
            <div class="flex space-x-6">
                <a href="{{ route('legal', 'imprint') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">{{ __('legal.imprint.title') }}</a>
                <a href="{{ route('legal', 'privacy') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">{{ __('legal.privacy.title') }}</a>
                <a href="{{ route('legal', 'terms') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">{{ __('legal.terms.title') }}</a>
            </div>
        </div>
    </div>
</footer>