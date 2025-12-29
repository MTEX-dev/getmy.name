@extends('layouts.profile')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('profile.design') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div
                    class="max-w-xl"
                    x-data="{ currentTemplate: '{{ old('template', $user->template ?? 'default') }}' }"
                    x-on:template-changed.prevent="currentTemplate = $event.detail"
                >
                    @include('profile.partials.update-template-form')

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between p-4 rounded-xl bg-getmyname-50 dark:bg-getmyname-950/30 border border-getmyname-100 dark:border-getmyname-900/50">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-getmyname-500 text-white shadow-sm">
                                    <i class="bi bi-eye-fill"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-getmyname-900 dark:text-getmyname-100">Live Preview</p>
                                    <p class="text-xs text-getmyname-700 dark:text-getmyname-400">See how "<span x-text="currentTemplate"></span>" looks with your data.</p>
                                </div>
                            </div>
                            <!--a
                                :href="`{{ route('profile.preview') }}/${currentTemplate}`"
                                target="_blank"
                                class="inline-flex items-center gap-2 rounded-lg bg-white dark:bg-gray-900 px-4 py-2 text-sm font-semibold text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-inset ring-getmyname-200 dark:ring-getmyname-800 hover:bg-getmyname-50 dark:hover:bg-gray-800 transition-all"
                            -->
                            <a
                                href="{{ route('profile.preview', ['template' => old('template', $user->template ?? 'default')]) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 rounded-lg bg-white dark:bg-gray-900 px-4 py-2 text-sm font-semibold text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-inset ring-getmyname-200 dark:ring-getmyname-800 hover:bg-getmyname-50 dark:hover:bg-gray-800 transition-all"
                            >
                                <span>View</span>
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection