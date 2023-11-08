@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $place->name }}</h1>
    <p>{{ $place->description }}</p>
    @if($place->file)
        <p>Fitxer: {{ $place->file->filepath }}</p>
    @endif
    <p>Autor: {{ $place->user->name }}</p>
    <!-- Afegeix més detalls aquí -->
</div>
@endsection