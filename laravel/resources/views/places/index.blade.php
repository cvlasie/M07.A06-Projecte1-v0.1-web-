@extends('layouts.box-app')

@section('box-title')
    <h1 class="text-2xl font-roboto text-deep-purple">{{ __('Places') }}</h1>
@endsection

@php
    $cols = [
        "id",
        "name",
        "description",
        "file_id",
        "latitude",
        "longitude",
        "visibility_id",
        "created_at",
        "updated_at"
    ];
@endphp

@section('box-content')
    <!-- Results -->
    <div class="bg-cream p-4">
        <x-table-index :cols="$cols" :rows="$places" 
            :enableActions="true" parentRoute="places"
            :enableSearch="true" :search="$search" />
    </div>
    <!-- Pagination -->
    <div class="mt-8">
        {{ $places->links() }}
    </div>
    <!-- Buttons -->
    <div class="mt-8 flex space-x-4">
        @can('create', App\Models\Place::class)
            <x-primary-button href="{{ route('places.create') }}" class="bg-orange text-deep-purple">
                {{ __('Add new place') }}
            </x-primary-button>
        @endcan
        <x-secondary-button href="{{ route('dashboard') }}" class="bg-light-orange text-deep-purple">
            {{ __('Back to dashboard') }}
        </x-secondary-button>
    </div>
@endsection
