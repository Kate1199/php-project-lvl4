@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h1 class="mb-5">{{ __('task.create_task') }}</h1>

    {{ Form::model($task, ['route' => 'tasks.store', 'class' => 'w-50']) }}
        @include('task.form')
        {{ Form::submit(__('task.create'), ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}
@endsection
