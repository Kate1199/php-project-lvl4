@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('task_status.edit') }}</h1>

{{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
    @include('task_status.form')
    {{ Form::submit( __('task_status.update')) }}
{{ Form::close() }}
@endsection
