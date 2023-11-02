@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4" style="color: #FF801F">Detalles del Post</h1>

        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-600">Autor: {{ $post->user->name }}</p>
        </div>

        @if ($post->image)
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->title }}" class="w-full">
        </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <p>{{ $post->content }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <p class="text-gray-600">Likes: {{ $likesCount }}</p>
            <form method="POST" action="{{ route('posts.like', $post->id) }}">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover-bg-blue-600">Like</button>
            </form>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <textarea name="content" class="w-full p-2" placeholder="Agrega un comentario" required></textarea>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Comentar</button>
            </form>
        </div>

        <!-- Mostrar los comentarios -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <h3 class="text-lg font-semibold" style="color: #FF801F">Comentarios</h3>
            <ul>
                @foreach ($post->comments as $comment)
                    <li class="mb-4">
                        <p class="text-gray-600">Autor: {{ $comment->user->name }}</p>
                        <p>{{ $comment->content }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('posts.index') }}" class="text-blue-500 mt-4">Volver a la lista de posts</a>
    </div>
@endsection