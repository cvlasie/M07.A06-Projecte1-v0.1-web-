@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4" style="color: #FF801F">Crear Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block" style="color: #FF801F">Título:</label>
                <input type="text" name="title" id="title" class="w-full p-2 border rounded">
                @error('title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block" style="color: #FF801F">Contenido:</label>
                <textarea name="content" id="content" class="w-full p-2 border rounded"></textarea>
                @error('content')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block" style="color: #FF801F">Imagen:</label>
                <input type="file" name="image" id="image" class="w-full">
                @error('image')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
        </form>
    </div>
@endsection
