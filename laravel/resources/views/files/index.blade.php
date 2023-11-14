@extends('layouts.box-app')

@section('box-title')
    {{ __('Files') }}
@endsection

@php
    $cols = [
        "id",
        "filepath",
        "filesize",
        "created_at",
        "updated_at"
    ];
@endphp

@section('box-content')
    <x-table-index :cols=$cols :rows=$files parentRoute='files' />
    <div class="mt-8">
        <x-primary-button href="{{ route('files.create') }}">
            {{ __('Add new file') }}
        </x-primary-button>
        <x-secondary-button href="{{ route('dashboard') }}">
            {{ __('Back to dashboard') }}
        </x-secondary-button>
    </div>
@endsection