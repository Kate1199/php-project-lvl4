@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-light border rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">
            {{ __('home.header') }}
        </h1>
        <p class="col-md-8 fs-4">
            {{ __('home.subheader') }}
        </p>
        <a href="{{ __('home.hexlet') }}" class="btn btn-primary" type="button">
            {{ __('home.learn_more') }}
        </a>
    </div>
</div>
@endsection
