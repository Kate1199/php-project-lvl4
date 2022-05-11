@extends('layouts.app')

@section('content')
@include('flash::message')

<h1 class="mb-5">{{ __('task_status.statuses') }}</h1>

@guest
@else
  <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('task_status.create_status') }}</a>
@endguest

<table class="table mt-2">
  <thead>
    <tr>
      <th scope="col">{{ __('task_status.id') }}</th>
      <th scope="col">{{ __('task_status.name') }}</th>
      <th scope="col">{{ __('task_status.created_at') }}</th>
      <th scope="col">{{ __('task_status.actions') }}</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($taskStatuses as $taskStatus)
        <tr>
          <th scope="row">{{ $taskStatus->id }}</th>
          <td>{{ $taskStatus->name }}</td>
          <td>{{ $taskStatus->created_at }}</td>
          <td>
            <a href="{{ route('task_statuses.edit', $taskStatus) }}" class="text-decoration-none">{{ __('task_status.edit') }}</a>
            <a href="{{ route('task_statuses.destroy', $taskStatus) }}" data-confirm="Вы уверены?"
              data-method="delete" rel="nofollow" class="text-danger text-decoration-none">{{ __('task_status.delete') }}</a>
          </td>
        </tr>
      @endforeach
  </tbody>
</table>
@endsection
