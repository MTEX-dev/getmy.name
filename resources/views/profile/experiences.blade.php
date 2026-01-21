@extends('layouts.profile')

@section('header_content')
    {{ __('profile.experiences.title') }}
@endsection

@section('content_inner')
    @include('profile.partials.update-experiences-form')
@endsection