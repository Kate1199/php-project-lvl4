@extends('layouts.app')

@section('content')
<h1 class="mb-5">Изменение статуса</h1>

{{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
    @include('task_status.form')
    {{ Form::submit('Обновить') }}
{{ Form::close() }}
@endsection
