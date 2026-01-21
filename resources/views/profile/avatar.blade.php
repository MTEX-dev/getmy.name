@extends('layouts.profile')

@section('header_content')
    {{ __('profile.avatar') }}
@endsection

@section('content_inner')
    @include('profile.partials.avatar-form')
@endsection