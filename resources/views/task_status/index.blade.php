@extends('layouts.app')

@section('content')
@include('flash::message')

<h1 class="mb-5">Статусы</h1>

@guest
@else
  <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>
@endguest

<table class="table mt-2">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Имя</th>
      <th scope="col">Дата создания</th>
      <th scope="col">Действия</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($taskStatuses as $taskStatus)
        <tr>
          <th scope="row">{{ $taskStatus->id }}</th>
          <td>{{ $taskStatus->name }}</td>
          <td>{{ $taskStatus->created_at }}</td>
          <td>
            <a href="{{ route('task_statuses.edit', $taskStatus) }}" class="text-decoration-none">Изменить</a>
            <a href="{{ route('task_statuses.destroy', $taskStatus) }}" data-confirm="Вы уверены?"
              data-method="delete" rel="nofollow" class="text-danger text-decoration-none">Удалить</a>
          </td>
        </tr>
      @endforeach
  </tbody>
</table>
@endsection
