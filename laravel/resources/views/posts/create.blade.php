@extends('layouts.box-app')

@section('box-title')
    {{ __('Add post') }}
@endsection

@section('box-content')
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <x-input-label for="body" :value="__('Body')" />
            <x-textarea name="body" id="body" class="block mt-1 w-full" :value="old('body')" />
        </div>
        <div>
            <x-input-label for="upload" :value="__('Upload')" />
            <x-text-input type="file" name="upload" id="upload" class="block mt-1 w-full" :value="old('upload')" />
            <!-- Espai per als missatges d'error -->
            <span id="error-upload" class="text-red-500 text-xs"></span>
        </div>
        <div>
            <x-input-label for="latitude" :value="__('Latitude')" />
            <x-text-input type="text" name="latitude" id="latitude" class="block mt-1 w-full" value="41.2310371" />
        </div>
        <div>
            <x-input-label for="longitude" :value="__('Longitude')" />
            <x-text-input type="text" name="longitude" id="longitude" class="block mt-1 w-full" value="1.7282036" />
        </div>
        <div>
            <x-input-label for="visibility_id" :value="__('Visibility')" />
            <select name="visibility_id" id="visibility_id" class="block mt-1 w-full">
                @foreach($visibilities as $visibility)
                    <option value="{{ $visibility->id }}">{{ $visibility->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-8">
            @can('create', App\Models\Post::class)
                <x-primary-button>
                    {{ __('Create') }}
                </x-primary-button>
            @endcan
            <x-secondary-button type="reset">
                {{ __('Reset') }}
            </x-secondary-button>
            <x-secondary-button href="{{ route('posts.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
        </div>
    </form>
@endsection
