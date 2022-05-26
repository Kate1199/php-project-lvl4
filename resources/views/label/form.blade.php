<div class="form-group mb-3">
    {{ Form::label('name', __('label.name')) }}
    {{ Form::text('name', $label->name, ['class' => 'form-control']) }}
</div>

<div class="form-group mb-2">
    {{ Form::label('description', __('label.description')) }}
    {{ Form::textarea('description', $label->description, ['class' => 'form-control']) }}
</div>

