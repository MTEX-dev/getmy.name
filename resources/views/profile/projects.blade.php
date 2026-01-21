@extends('layouts.profile')

@section('header_content')
    {{ __('Projects') }}
@endsection

@section('content_inner')
    @include('profile.partials.update-projects-form')
@endsection