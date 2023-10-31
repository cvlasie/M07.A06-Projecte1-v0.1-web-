<!DOCTYPE html>
<html>
<head>
    <title>Recursos - Archivos Subidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-semibold mb-6">{{ __('Recursos') }}</h2>
        <a href="{{ url('/files') }}" class="text-blue-500 hover:underline">{{ __('Archivos') }}</a>

        <h3 class="text-lg mt-6 mb-4">{{ __('Archivos Subidos') }}</h3>

        @if (count($files) > 0)
            <ul>
                @foreach ($files as $file)
                    <li class="mb-2">
                        <a href="{{ route('files.show', $file) }}" class="text-blue-500 hover:underline">{{ $file->filepath }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-4">{{ __('No se han subido archivos.') }}</p>
        @endif
    </div>
</body>
</html>
