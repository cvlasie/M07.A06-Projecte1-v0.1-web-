@extends('layouts.box-app')

@section('box-title')
    {{ __('Post') . " " . $post->id }}
@endsection

@section('box-content')
<x-columns columns=2>
    @section('column-1')
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    @endsection

    @section('column-2')
        <table class="table">
            <tbody>                
                <tr>
                    <td><strong>ID<strong></td>
                    <td>{{ $post->id }}</td>
                </tr>
                <tr>
                    <td><strong>Body</strong></td>
                    <td>{{ $post->body }}</td>
                </tr>
                <tr>
                    <td><strong>Lat</strong></td>
                    <td>{{ $post->latitude }}</td>
                </tr>
                <tr>
                    <td><strong>Lng</strong></td>
                    <td>{{ $post->longitude }}</td>
                </tr>
                <tr>
                    <td><strong>Author</strong></td>
                    <td>{{ $author->name }}</td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td>{{ $post->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Updated</strong></td>
                    <td>{{ $post->updated_at }}</td>
                </tr>
                <!-- Mostrar el número total de likes -->
                <tr>
                    <td><strong>Likes</strong></td>
                    <td>{{ $post->likes_count }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-8">
            <!-- Lógica para mostrar los botones de editar, eliminar y volver -->
            <x-primary-button href="{{ route('posts.edit', $post) }}">
                {{ __('Edit') }}
            </x-primary-button>
            <x-danger-button href="{{ route('posts.delete', $post) }}">
                {{ __('Delete') }}
            </x-danger-button>
            <x-secondary-button href="{{ route('posts.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>

            <!-- Lógica para mostrar los botones de agregar o eliminar likes -->
            <form method="POST" action="{{ $liked ? route('posts.unlike', $post) : route('posts.like', $post) }}" class="mt-4">
                @csrf
                @if($liked)
                    @method('DELETE')
                @endif
                <x-primary-button type="submit">
                    {{ $liked ? 'Unlike' : 'Like' }}
                </x-primary-button>
            </form>
        </div>
    @endsection
</x-columns>
@endsection
