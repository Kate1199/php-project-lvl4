@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="mb-5">{{ __('label.edit_label') }}</h1>
    {{ Form::model($label, ['route' => ['labels.update', $label->id], 'method' => 'patch', 'class' => 'w-50']) }}
        @include('label.form')
        {{ Form::submit(__('label.update'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
