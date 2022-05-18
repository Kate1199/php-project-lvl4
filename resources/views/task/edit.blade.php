@extends('layouts.app')

@section('content')
    {{ Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'patch', 'class' => 'w-50']) }}
        @include('task.form')
        {{ Form::submit(__('task.update'), ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}
@endsection
