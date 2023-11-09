@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Afegir Nou Lloc</h1>
    <form action="{{ route('places.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nom del Lloc</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <!-- Afegeix més camps aquí segons el teu model 'Place' -->

        <div class="form-group">
            <label for="media">Fitxer Multimedia</label>
            <input type="file" class="form-control-file" id="media" name="media" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
