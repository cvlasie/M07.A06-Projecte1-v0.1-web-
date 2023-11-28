@extends('layouts.box-app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
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
                    <td>{{ $place->id }}</td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>{{ $place->name }}</td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{ $place->description }}</td>
                </tr>
                <tr>
                    <td><strong>Lat</strong></td>
                    <td>{{ $place->latitude }}</td>
                </tr>
                <tr>
                    <td><strong>Lng</strong></td>
                    <td>{{ $place->longitude }}</td>
                </tr>
                <tr>
                    <td><strong>Author</strong></td>
                    <td>{{ $author->name }}</td>
                </tr>
                <tr>
                    <td><strong>Visibility</strong></td>
                    <td>{{ $place->visibility->name }}</td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td>{{ $place->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Updated</strong></td>
                    <td>{{ $place->updated_at }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-8">
            @can('update', $place)
                <x-primary-button href="{{ route('places.edit', $place) }}">
                    {{ __('Edit') }}
                </x-primary-button>
            @endcan

            @can('delete', $place)
                <x-danger-button href="{{ route('places.delete', $place) }}">
                    {{ __('Delete') }}
                </x-danger-button>
            @endcan
            <x-secondary-button href="{{ route('places.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
        </div>

        {{-- Botó de Favorite/Unfavorite --}}
        @auth
            @can('favorite', $place)
                @if ($isFavorited)
                    <form action="{{ route('places.unfavorite', $place) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-secondary-button type="submit">
                        {{ __('Remove Favorite') }}
                        </x-secondary-button>
                    </form>
                @else
                    <form action="{{ route('places.favorite', $place) }}" method="POST">
                        @csrf
                        <x-secondary-button type="submit">
                            {{ __('Add to Favorites') }}
                        </x-secondary-button>
                    </form>
                @endif
            @endcan
        @endauth

        {{-- Comptador de Favorites --}}
        <p>Favorites: {{ $favoritesCount }}</p>
        
    @endsection
</x-columns>
@endsection
