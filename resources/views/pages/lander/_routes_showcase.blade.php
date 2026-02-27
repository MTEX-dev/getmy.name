<section class="py-24 sm:py-32 bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-center">
            
            {{-- Content --}}
            <div class="lg:order-2 lg:pl-8">
                <h2 class="text-base font-semibold leading-7 text-getmyname-600 dark:text-getmyname-400">
                    {{ __('lander.routes.section_title') }}
                </h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">
                    {{ __('lander.routes.title') }}
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    {{ __('lander.routes.description') }}
                </p>

                <dl class="mt-10 max-w-xl space-y-6 text-base leading-7 text-gray-700 dark:text-gray-300 lg:max-w-none">
                    <div class="relative pl-9">
                        <dt class="inline font-semibold text-gray-900 dark:text-gray-100">
                            <i class="bi bi-check-circle-fill absolute left-0 top-1 h-5 w-5 text-getmyname-600"></i>
                            {{ __('lander.routes.profile_title') }}
                        </dt>
                        <dd class="inline ml-1">
                            — {{ __('lander.routes.profile_desc') }}
                        </dd>
                    </div>
                    <div class="relative pl-9">
                        <dt class="inline font-semibold text-gray-900 dark:text-gray-100">
                            <i class="bi bi-check-circle-fill absolute left-0 top-1 h-5 w-5 text-getmyname-600"></i>
                            {{ __('lander.routes.json_title') }}
                        </dt>
                        <dd class="inline ml-1">
                            — {{ __('lander.routes.json_desc') }}
                        </dd>
                    </div>
                    <div class="relative pl-9">
                        <dt class="inline font-semibold text-gray-900 dark:text-gray-100">
                            <i class="bi bi-check-circle-fill absolute left-0 top-1 h-5 w-5 text-getmyname-600"></i>
                            {{ __('lander.routes.pfp_title') }}
                        </dt>
                        <dd class="inline ml-1">
                            — {{ __('lander.routes.pfp_desc') }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Code Preview --}}
            <div class="lg:order-1">
                <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-red-500"></div>
                            <div class="h-3 w-3 rounded-full bg-yellow-400"></div>
                            <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">routes/web.php</span>
                    </div>
                    <pre class="text-sm overflow-x-auto text-gray-800 dark:text-gray-200"><code class="language-php"><span class="text-gray-500">// Profile routes</span>
<span class="text-purple-600 dark:text-purple-400">Route</span>::<span class="text-blue-600 dark:text-blue-400">get</span>(<span class="text-green-600 dark:text-green-400">'@{username}'</span>, [<span class="text-purple-600 dark:text-purple-400">ProfileController</span>::<span class="text-blue-600 dark:text-blue-400">class</span>, <span class="text-green-600 dark:text-green-400">'show'</span>]);
<span class="text-purple-600 dark:text-purple-400">Route</span>::<span class="text-blue-600 dark:text-blue-400">get</span>(<span class="text-green-600 dark:text-green-400">'@{username}/json'</span>, [<span class="text-purple-600 dark:text-purple-400">ProfileController</span>::<span class="text-blue-600 dark:text-blue-400">class</span>, <span class="text-green-600 dark:text-green-400">'json'</span>]);

<span class="text-gray-500">// Avatar routes</span>
<span class="text-purple-600 dark:text-purple-400">Route</span>::<span class="text-blue-600 dark:text-blue-400">get</span>(<span class="text-green-600 dark:text-green-400">'/{username}.png'</span>, [<span class="text-purple-600 dark:text-purple-400">AvatarController</span>::<span class="text-blue-600 dark:text-blue-400">class</span>, <span class="text-green-600 dark:text-green-400">'show'</span>]);
<span class="text-purple-600 dark:text-purple-400">Route</span>::<span class="text-blue-600 dark:text-blue-400">get</span>(<span class="text-green-600 dark:text-green-400">'@{username}/pfp'</span>, [<span class="text-purple-600 dark:text-purple-400">AvatarController</span>::<span class="text-blue-600 dark:text-blue-400">class</span>, <span class="text-green-600 dark:text-green-400">'show'</span>]);</code></pre>
                </div>

                {{-- Example URLs --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-center gap-3 rounded-lg bg-white dark:bg-gray-800 px-4 py-3 shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                        <i class="bi bi-person-circle text-getmyname-600 dark:text-getmyname-400 text-xl"></i>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('lander.routes.example_label') }}</p>
                            <code class="text-sm font-medium text-gray-900 dark:text-gray-100">getmy.name/@janedoe</code>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-white dark:bg-gray-800 px-4 py-3 shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                        <i class="bi bi-filetype-json text-getmyname-600 dark:text-getmyname-400 text-xl"></i>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('lander.routes.example_label') }}</p>
                            <code class="text-sm font-medium text-gray-900 dark:text-gray-100">getmy.name/@janedoe/json</code>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>