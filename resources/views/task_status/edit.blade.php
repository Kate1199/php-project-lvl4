@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('task_status.edit') }}</h1>

{{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH', 'class' => 'w-50']) }}
    @include('task_status.form')
    {{ Form::submit( __('task_status.update'), ['class' => 'btn btn-primary mt-3']) }}
{{ Form::close() }}
@endsection
