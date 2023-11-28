@extends('layouts.box-app')

@section('box-title')
    {{ __('Add place') }}
@endsection

@section('box-content')
    <form id="create-place-form" method="POST" action="{{ route('places.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input type="text" name="name" id="name" class="block mt-1 w-full" :value="old('name')" />
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-textarea name="description" id="description" class="block mt-1 w-full" :value="old('description')" />
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
            <x-primary-button>
                {{ __('Create') }}
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