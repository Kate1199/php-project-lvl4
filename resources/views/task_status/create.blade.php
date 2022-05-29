@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('task_status.create_status') }}</h1>

{{ Form::model($taskStatus, ['route' => 'task_statuses.store', 'class' => 'w-50']) }}
    @include('task_status.form')
    {{ Form::submit( __('task_status.create'), ['class' => 'btn btn-primary mt-3']) }}
{{ Form::close() }}
@endsection

