@extends('layouts.profile')

@section('header_content')
    {{ __('profile.education') }}
@endsection

@section('content_inner')
    @include('profile.partials.update-education-form')
@endsection