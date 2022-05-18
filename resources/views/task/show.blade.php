@extends('layouts.app')

@section('content')
    <h1>
        {{ __('task.show') }}
        {{ $task->name }}
    </h1>

    <p>{{ __('task.name') }}: {{ $task->name }}</p>
    <p>{{ __('task.status') }}: {{ $status }}</p>
    <p>{{ __('task.description') }}: {{ $task->description }}</p>
@endsection
