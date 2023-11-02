@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4" style="color: #FF801F">Editar Post</h1>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block" style="color: #FF801F">Título:</label>
                <input type="text" name="title" id="title" value="{{ $post->title }}" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="content" class="block" style="color: #FF801F">Contenido:</label>
                <textarea name="content" id="content" class="w-full p-2 border rounded">{{ $post->content }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block" style="color: #FF801F">Imagen actual:</label>
                @if($post->image)
                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="Imagen actual" class="mb-2">
                @else
                    <p>No hay imagen actual.</p>
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="w-full p-2 border rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover-bg-blue-600">Actualizar</button>
        </form>
    </div>
@endsection
