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
        <form id="edit-place-form" method="POST" action="{{ route('places.update', $place) }}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input type="text" name="name" id="name" class="block mt-1 w-full" :value="$place->name" />
            </div>
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea name="description" id="description" class="block mt-1 w-full" :value="$place->description" />
            </div>
            <div>
                <x-input-label for="upload" :value="__('Upload')" />
                <x-text-input type="file" name="upload" id="upload" class="block mt-1 w-full" />
                <!-- Espai per als missatges d'error -->
                <span id="error-upload" class="text-red-500 text-xs"></span>
            </div>
            <div>
                <x-input-label for="latitude" :value="__('Latitude')" />
                <x-text-input type="text" name="latitude" id="latitude" class="block mt-1 w-full" :value="$place->latitude" />
            </div>
            <div>
                <x-input-label for="longitude" :value="__('Longitude')" />
                <x-text-input type="text" name="longitude" id="longitude" class="block mt-1 w-full" :value="$place->longitude" />
            </div>
            <div>
                <x-input-label for="visibility_id" :value="__('Visibility')" />
                <select name="visibility_id" id="visibility_id" class="block mt-1 w-full">
                    @foreach($visibilities as $visibility)
                        <option value="{{ $visibility->id }}" {{ $place->visibility_id == $visibility->id ? 'selected' : '' }}>{{ $visibility->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-8">
                <x-primary-button>
                    {{ __('Update') }}
                </x-primary-button>
                <x-secondary-button type="reset">
                    {{ __('Reset') }}
                </x-secondary-button>
                <x-secondary-button href="{{ route('places.index') }}">
                    {{ __('Back to list') }}
                </x-secondary-button>
            </div>
        </form>
    @endsection
</x-columns>
@endsection