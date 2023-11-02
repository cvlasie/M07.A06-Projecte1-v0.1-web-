@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4" style="color: #FF801F">Lista de Posts</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover-bg-blue-600">Crear Post</a>

        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-left" style="color: #FF801F">Título</th>
                    <th class="text-left" style="color: #FF801F">Autor</th>
                    <th class="text-left" style="color: #FF801F">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if ($post->user)
                            {{ $post->user->name }}
                        @else
                            Usuario no disponible
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">Ver</a>
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-500 ml-2">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
