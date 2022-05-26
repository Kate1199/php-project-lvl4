@extends('layouts.app')

@section('content')

    @include('flash::message')
    
    <h1 class="mb-5">
        {{ __('label.labels') }}
    </h1>

    @guest
    @else
        <a href=" {{ route('labels.create') }}" class="btn btn-primary">
            {{ __('label.create_label') }}
        </a>
    @endguest

    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('label.id') }}</th>
                <th>{{ __('label.name') }}</th>
                <th>{{ __('label.description') }}</th>
                <th>{{ __('label.created_at') }}</th>
                @guest
                @else
                    <th>{{ __('label.actions') }}</th>
                @endguest
            </tr>
        </thead>
        <tbody>
            @foreach($labels as $label)
                <tr>
                    <td>{{ $label->id }}</td>
                    <td>{{ $label->name }}</td>
                    <td>{{ $label->description }}</td>
                    <td>{{ $label->created_at }}</td>
                    @guest
                    @else
                    <td>
                        <a class="text-danger text-decoration-none" href=" {{ route('labels.destroy', ['label' => $label->id]) }}" data-confirm="Вы уверены?" data-method="delete">
                            {{ __('label.delete') }}
                        </a>
                        <a href="{{ route('labels.edit', ['label' => $label->id]) }}" class="text-decoration-none">
                            {{ __('label.edit') }}
                        </a>
                    </td>
                    @endguest
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
