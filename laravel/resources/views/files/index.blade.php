<div class="container">
    <h2>{{ __('Recursos') }}</h2>
    <a href="{{ url('/files') }}">{{ __('Archivos') }}</a>

    <h3>{{ __('Archivos Subidos') }}</h3>

    @if (count($files) > 0)
        <ul>
            @foreach ($files as $file)
                <li>
                    <a href="{{ route('files.show', $file) }}">{{ $file->filepath }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>{{ __('No se han subido archivos.') }}</p>
    @endif
</div>
