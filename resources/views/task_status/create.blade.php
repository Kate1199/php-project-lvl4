@extends('layouts.app')

@section('content')
<h1 class="mb-5">@lang('create_status')</h1>

{{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    @include('task_status.form')
    {{ Form::submit(@lang('create')) }}
{{ Form::close() }}
@endsection

