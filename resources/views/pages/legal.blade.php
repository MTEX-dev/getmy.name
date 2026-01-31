@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('legal.' . $section . '.title') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <div class="flex border-b border-gray-200 dark:border-gray-700 mb-4">
                        @foreach ($sections as $_section)
                            <a href="{{ route('legal', ['section' => $_section]) }}"
                                class="py-2 px-4 text-sm font-medium
                                {{ $_section == $section ? 'text-getmyname-600 border-b-2 border-getmyname-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                                {{ __('legal.' . $_section . '.tab_title') }}
                            </a>
                        @endforeach
                    </div>
                    <div class="text-gray-900 dark:text-gray-100 prose dark:prose-invert">
                        {!! Str::markdown(__('legal.' . $section . '.content')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection