{{ Form::token() }}

<div class="form-group mb-3">
    {{ Form::label('name', __('task_status.name')) }}
    {{ Form::text('name', $taskStatus->name, ['class' => 'form-control', 'required']) }}
</div>
