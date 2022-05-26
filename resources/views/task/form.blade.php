{{ Form::token() }}

<div class="form-group mb-3">
    {{ Form::label('name', __('task.name')) }}
    {{ Form::text('name', $task->name, ['class' => 'form-control']) }}
</div>
<div class="form-group mb-3">
    {{ Form::label('description', __('task.description')) }}
    {{ Form::textarea('description', $task->description, ['class' => 'form-control']) }}
</div>

<div class="form-group mb-3">
        {{ Form::label('status_id', __('task.status')) }}
        {{ Form::select('status_id', $taskStatuses, null, ['placeholder' => '-------', 'class' => 'form-control']) }}
</div>

<div class="form-group mb-3">
    {{ Form::label('assigned_to_id', __('task.assigned_to')) }}
    {{ Form::select('assigned_to_id', $assignedToUsers, null, ['placeholder' => '-------', 'class' => 'form-control']) }}
</div>

<div class="form-group mb-3">
    {{ Form::label('labels', __('task.labels')) }}
    {{ Form::select('labels', $labels, null, ['placeholder' => '-------', 'class' => 'form-control', 'multiple' => 'multiple', 'name' => 'labels[]']) }}
</div>
