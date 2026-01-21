@extends('layouts.profile')

@section('header_content')
    {{ __('profile.password') }}
@endsection

@section('content_inner')
    @include('profile.partials.update-password-form')
@endsection