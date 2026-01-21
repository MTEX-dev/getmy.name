@extends('layouts.profile')

@section('header_content')
    {{ __('profile.api_requests.title') }}
@endsection

@section('content_inner')
    @include('profile.partials.show-api-requests')
@endsection