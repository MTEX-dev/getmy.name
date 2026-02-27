<section class="py-24 sm:py-32 bg-white dark:bg-gray-800">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <span class="inline-flex items-center rounded-full bg-getmyname-100 dark:bg-getmyname-900/30 px-4 py-1.5 text-sm font-medium text-getmyname-700 dark:text-getmyname-300 ring-1 ring-inset ring-getmyname-600/20">
                <i class="bi bi-stars mr-2"></i>
                {{ __('lander.whats_new.badge') }}
            </span>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">
                {{ __('lander.whats_new.title') }}
            </h2>
            <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-400">
                {{ __('lander.whats_new.subtitle') }}
            </p>
        </div>

        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3 lg:gap-y-16">
                
                {{-- New Social Links --}}
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-getmyname-600">
                            <i class="bi bi-share-fill text-white text-xl"></i>
                        </div>
                        {{ __('lander.whats_new.socials_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.whats_new.socials_description') }}
                    </dd>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-codepen mr-1"></i> CodePen
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-instagram mr-1"></i> Instagram
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-youtube mr-1"></i> YouTube
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-stack-overflow mr-1"></i> StackOverflow
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-file-code mr-1"></i> dev.to
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-hash mr-1"></i> Hashnode
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-npm mr-1"></i> npm
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-box mr-1"></i> Product Hunt
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-people mr-1"></i> Polywork
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-git mr-1"></i> GitLab
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-brush mr-1"></i> Dribbble
                        </span>
                        <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <i class="bi bi-palette mr-1"></i> Figma
                        </span>
                    </div>
                </div>

                {{-- Pronouns --}}
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-getmyname-600">
                            <i class="bi bi-person-heart text-white text-xl"></i>
                        </div>
                        {{ __('lander.whats_new.pronouns_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.whats_new.pronouns_description') }}
                    </dd>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center rounded-full bg-getmyname-50 dark:bg-getmyname-900/30 px-3 py-1 text-sm text-getmyname-700 dark:text-getmyname-300">
                            she/her
                        </span>
                        <span class="inline-flex items-center rounded-full bg-getmyname-50 dark:bg-getmyname-900/30 px-3 py-1 text-sm text-getmyname-700 dark:text-getmyname-300">
                            he/him
                        </span>
                        <span class="inline-flex items-center rounded-full bg-getmyname-50 dark:bg-getmyname-900/30 px-3 py-1 text-sm text-getmyname-700 dark:text-getmyname-300">
                            they/them
                        </span>
                        <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700 px-3 py-1 text-sm text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-200 dark:ring-gray-600">
                            custom...
                        </span>
                    </div>
                </div>

                {{-- Profile Routes --}}
                <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-getmyname-600">
                            <i class="bi bi-link-45deg text-white text-xl"></i>
                        </div>
                        {{ __('lander.whats_new.routes_title') }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
                        {{ __('lander.whats_new.routes_description') }}
                    </dd>
                    <div class="mt-4 space-y-2">
                        <code class="block rounded bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-sm text-gray-800 dark:text-gray-200">
                            @{username}
                        </code>
                        <code class="block rounded bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-sm text-gray-800 dark:text-gray-200">
                            @{username}/json
                        </code>
                        <code class="block rounded bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-sm text-gray-800 dark:text-gray-200">
                            /{username}.png
                        </code>
                    </div>
                </div>

            </dl>
        </div>
    </div>
</section>