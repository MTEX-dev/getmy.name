@extends('layouts.app')

@section('content')
    <main class="pt-20 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-3xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-getmyname-600 dark:text-getmyname-400">
                        {{ __('api_docs.subtitle') }}
                    </h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                        {{ __('api_docs.title') }}
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        {{ __('api_docs.description') }}
                    </p>
                </div>

                <div class="mx-auto mt-20 max-w-none">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                        <aside class="lg:col-span-3">
                            <div class="sticky top-20 space-y-4">
                                @foreach (
                                    [
                                        'profile',
                                        'skills',
                                        'projects',
                                        'experiences',
                                        'education',
                                        'socials',
                                        'about_me',
                                    ]
                                    as $section
                                )
                                    <a href="#{{ $section }}"
                                        class="block text-lg font-medium text-gray-700 hover:text-getmyname-600 dark:text-gray-300 dark:hover:text-getmyname-400">
                                        {{ __('api_docs.' . $section . '.title') }}
                                    </a>
                                @endforeach
                            </div>
                        </aside>

                        <div class="mt-16 lg:col-span-9 lg:mt-0">
                            @foreach (
                                [
                                    'profile' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />',
                                        'endpoints' => [
                                            'show' => 'GET /api/v1/profile/{username}',
                                            'update' => 'PATCH /api/v1/profile',
                                            'update_avatar' => 'PATCH /api/v1/profile/avatar',
                                            'delete_avatar' => 'DELETE /api/v1/profile/avatar',
                                        ],
                                    ],
                                    'skills' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />',
                                        'endpoints' => [
                                            'index' => 'GET /api/v1/profile/{username}/skills',
                                            'store' => 'POST /api/v1/skills',
                                            'destroy' => 'DELETE /api/v1/skills/{skill}',
                                        ],
                                    ],
                                    'projects' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />',
                                        'endpoints' => [
                                            'index' => 'GET /api/v1/profile/{username}/projects',
                                            'store' => 'POST /api/v1/projects',
                                            'destroy' => 'DELETE /api/v1/projects/{project}',
                                        ],
                                    ],
                                    'experiences' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />',
                                        'endpoints' => [
                                            'index' => 'GET /api/v1/profile/{username}/experiences',
                                            'store' => 'POST /api/v1/experiences',
                                            'destroy' => 'DELETE /api/v1/experiences/{experience}',
                                        ],
                                    ],
                                    'education' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />',
                                        'endpoints' => [
                                            'index' => 'GET /api/v1/profile/{username}/education',
                                            'store' => 'POST /api/v1/education',
                                            'destroy' => 'DELETE /api/v1/education/{education}',
                                        ],
                                    ],
                                    'socials' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />',
                                        'endpoints' => [
                                            'index' => 'GET /api/v1/profile/{username}/socials',
                                            'update' => 'PATCH /api/v1/socials',
                                        ],
                                    ],
                                    'about_me' => [
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />',
                                        'endpoints' => [
                                            'index' => 'GET /api/v1/profile/{username}/about-me',
                                            'update' => 'PATCH /api/v1/about-me',
                                        ],
                                    ],
                                ]
                                as $section => $data
                            )
                                <section id="{{ $section }}" class="mb-16 scroll-mt-24">

                                    <div class="relative pl-16">
                                        <div
                                            class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-getmyname-600">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                {!! $data['icon'] !!}
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-semibold leading-7">
                                            {{ __('api_docs.' . $section . '.title') }}
                                        </h3>
                                        <p class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">
                                            {{ __('api_docs.' . $section . '.description') }}
                                        </p>
                                    </div>
                                    <div class="mt-8 space-y-4">
                                        @foreach ($data['endpoints'] as $endpointName => $endpointPath)
                                            <div
                                                class="rounded-md bg-gray-100 p-4 dark:bg-gray-800 dark:text-gray-100">
                                                <strong class="block text-lg font-medium">
                                                    {{ __('api_docs.endpoints.' . $endpointName) }}:
                                                </strong>
                                                <code
                                                    class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $endpointPath }}</code>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection