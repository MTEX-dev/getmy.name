@extends('layouts.app')

@php
$startAtFooter = true;
@endphp

@section('content')
    <main class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        @include('pages.lander._hero')
        @include('pages.lander._features')
        @include('pages.lander._api_showcase')
        @include('pages.lander._stats')
        @include('pages.lander._call_to_action')
    </main>
@endsection