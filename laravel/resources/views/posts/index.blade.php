@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4" style="color: #FF801F">Lista de Posts</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover-bg-blue-600">Crear Post</a>

        <!-- Formulario de búsqueda -->
        <form action="{{ route('posts.search') }}" method="GET" class="mt-4">
            <div class="mb-4">
                <input type="text" name="query" placeholder="Buscar..." class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover-bg-blue-600">Buscar</button>
        </form>

        <!-- Mostrar errores aquí -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">¡Hubo un problema!</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
