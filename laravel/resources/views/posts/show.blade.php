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
                <!-- Resto de la información del post... -->
            </tbody>
        </table>

        <!-- Sección de Comentarios -->
        <div class="mt-8">
            <h2>{{ __('Comments') }}</h2>

            @if ($post->comments)
                @forelse ($post->comments as $comment)
                    <div>
                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}

                        <!-- Botón de Eliminar Comentario -->
                        @can('delete', $comment)
                            <form method="post" action="{{ route('posts.comments.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">{{ __('Delete Comment') }}</button>
                            </form>
                        @endcan
                    </div>
                @empty
                    <p>{{ __('No comments yet.') }}</p>
                @endforelse
            @else
                <p>{{ __('Comments are not available for this post.') }}</p>
            @endif

            <!-- Formulario para Agregar Comentario -->
            @auth
                <form method="post" action="{{ route('posts.comments.store', ['post' => $post->id]) }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea name="body" placeholder="{{ __('Write your comment') }}"></textarea>
                    <button type="submit">{{ __('Add Comment') }}</button>
                </form>
            @else
                <p>{{ __('Login to add comments.') }}</p>
            @endauth
        </div>

        <div class="mt-8">
            <!-- Resto de los botones y acciones... -->

            @can('viewAny', App\Models\Post::class)
                <x-secondary-button href="{{ route('posts.index') }}">
                    {{ __('Back to list') }}
                </x-secondary-button>
            @endcan
        </div>

        <div class="mt-8">
            <p>{{ $numLikes . " " . __('likes') }}</p>
            @include('partials.buttons-likes')
        </div>
    @endsection
</x-columns>
@endsection