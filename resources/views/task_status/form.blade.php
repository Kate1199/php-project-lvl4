{{ Form::token() }}

<div class="form-group mb-3">
    {{ Form::label('name', __('task_status.name')) }}
    
    @error('name')
    {{ Form::text('name', $taskStatus->name, ['class' => 'form-control is-invalid']) }}
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @else
    {{ Form::text('name', $taskStatus->name, ['class' => 'form-control']) }}
    @enderror

</div>
