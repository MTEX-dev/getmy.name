@extends('layouts.app')

@php
$startAtFooter = true;
@endphp

@section('content')
    <main class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        @include('pages.lander._hero')
        @include('pages.lander._features')
        @include('pages.lander._whats_new')
        @include('pages.lander._api_showcase')
        @include('pages.lander._routes_showcase')
        @include('pages.lander._stats', $stats_data)
        @include('pages.lander._cta_banner')
    </main>
@endsection