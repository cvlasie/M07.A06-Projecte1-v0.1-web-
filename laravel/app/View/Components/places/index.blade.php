@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Llocs</h1>
    <a href="{{ route('places.create') }}" class="btn btn-primary">Afegir Nou Lloc</a>
    <div class="mt-4">
        @foreach ($places as $place)
            <div class="card mb-3">
                <div class="card-header">{{ $place->name }}</div>
                <div class="card-body">
                    <p>{{ $place->description }}</p>
                    @if($place->file)
                        <p>Fitxer: {{ $place->file->filepath }}</p>
                    @endif
                    <p>Autor: {{ $place->user->name }}</p>
                    <a href="{{ route('places.show', $place->id) }}" class="btn btn-secondary">Veure Detalls</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $places->links() }}
    </div>
</div>
@endsection
