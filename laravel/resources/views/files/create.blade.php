@extends('layouts.box-app')

@section('box-title')
    {{ __('Add file') }}
@endsection

@section('box-content')
    <form id="create-file-form" method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <x-input-label for="upload" :value="__('Upload')" />
            <x-text-input type="file" name="upload" id="upload" class="block mt-1 w-full" :value="old('upload')" />
            <!-- Espai per als missatges d'error -->
            <span id="error-upload" class="text-red-500 text-xs"></span>
        </div>
        <div class="mt-8">
            <x-primary-button>
                {{ __('Create') }}
            </x-primary-button>
            <x-secondary-button type="reset">
                {{ __('Reset') }}
            </x-secondary-button>
            <x-secondary-button href="{{ route('files.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
        </div>
    </form>
@endsection
