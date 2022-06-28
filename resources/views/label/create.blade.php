@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('label.create_label') }}</h1>
    {{ Form::model($label, ['route' => 'labels.store', 'class' => 'w-50']) }}
        @include('label.form')
        {{ Form::submit(__('label.create'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
