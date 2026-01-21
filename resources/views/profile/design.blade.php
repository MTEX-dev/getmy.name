@extends('layouts.profile')

@section('header_content')
    {{ __('profile.design') }}
@endsection

@section('content_inner')
    <div
        x-data="{ currentTemplate: '{{ old('template', $user->template ?? 'default') }}' }"
        x-on:template-preview.window="currentTemplate = $event.detail"
    >
        @include('profile.partials.update-template-form')

        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row items-center justify-between p-6 rounded-2xl bg-gradient-to-r from-getmyname-50 to-white dark:from-getmyname-950/20 dark:to-gray-900 border border-getmyname-100 dark:border-getmyname-900/50 gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-getmyname-500 text-white shadow-lg shadow-getmyname-500/20">
                        <i class="bi bi-eye-fill text-xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-bold text-gray-900 dark:text-gray-100">Live Preview</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Check out the <span class="font-mono font-bold text-getmyname-600 dark:text-getmyname-400" x-text="currentTemplate"></span> template.
                        </p>
                    </div>
                </div>
                
                <a
                    :href="`{{ route('profile.preview') }}/${currentTemplate}`"
                    target="_blank"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-getmyname-600 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-getmyname-700 hover:shadow-lg transition-all active:scale-95"
                >
                    <span>View Profile</span>
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection