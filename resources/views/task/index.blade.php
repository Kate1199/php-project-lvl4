@extends('layouts.app')

@section('content')

    @include('flash::message')
    <h5 class="mb-5">{{ __('task.tasks') }}</h5>

    <div class="d-flex mb-3">
        <div>
            {{ Form::open(['route' => 'tasks.index', 'method' => 'get']) }}
            <div class="row g1">
                <div class="col">
                    {{ Form::select('filter[status_id]', $taskStatuses, optional($filters)['status_id'], ['placeholder' => __('task.status'), 'class' => 'form-select me-2']) }}
                </div>

                <div class="col">
                    {{ Form::select('filter[created_by_id]', $users, null, ['placeholder' => __('task.created_by'), 'class' => 'form-select me-2']) }}
                </div>

                <div class="col">
                    {{ Form::select('filter[assigned_to_id]', $users, null, ['placeholder' => __('task.assigned_to'), 'class' => 'form-select me-2']) }}
                </div>

                <div class="col">
                    {{ Form::submit(__('task.apply'), ['class' => 'btn btn-outline-primary me-2']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
                <div class="ms-auto">
                    @guest
                    @else
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">Создать задачу</a>
                    @endguest
                </div>
    </div>

            <table class="table me-2">
                <thead>
                    <tr>
                        <th>{{ __('task.id') }}</th>
                        <th>{{ __('task.status') }}</th>
                        <th>{{ __('task.name') }}</th>
                        <th>{{ __('task.created_by') }}</th>
                        <th>{{ __('task.assigned_to') }}</th>
                        <th>{{ __('task.created_at') }}</th>
                        @guest
                        @else
                            <th>{{ __('task.actions') }}</th>
                        @endguest
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-decoration-none">
                                {{ $task->name }}
                            </a>
                        </td>
                        <td>{{ $task->created_by }}</td>
                        <td>{{ $task->assigned_to }}</td>
                        <td>{{ $task->created_at }}</td>
                        @guest
                        @else
                        <td>
                            @if($task->created_by_id === $id)
                            <a href="{{ route('tasks.destroy', $task->id) }}" data-confirm="Вы уверены?"
                                data-method="delete" rel="nofollow" class="text-danger text-decoration-none">{{ __('task.delete') }}</a>
                            @endif
                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-decoration-none">
                                {{ __('task.edit') }}
                            </a>
                        </td>
                        @endguest
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $tasks->links() }}
@endsection
