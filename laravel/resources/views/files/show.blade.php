<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Archivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white p-6 rounded shadow-lg">
        <h1 class="text-2xl font-semibold mb-6">Detalles del Archivo</h1>

        <div class="border rounded p-4 mb-4">
            <h5 class="font-semibold text-lg">Nombre del Archivo:</h5>
            <p>{{ $file->filepath }}</p>
            <h5 class="font-semibold text-lg mt-2">Tamaño del Archivo:</h5>
            <p>{{ $file->filesize }} bytes</p>
            <h5 class="font-semibold text-lg mt-2">URL del Archivo:</h5>
            <a href="{{ $fileUrl }}" target="_blank" class="text-blue-500 hover:underline">{{ $fileUrl }}</a>
        </div>

        <img src="{{ asset("storage/{$file->filepath}") }}" class="w-full max-w-lg mx-auto mb-4" />

        <a href="{{ route('files.edit', $file) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mr-4">Editar Archivo</a>

        <form method="post" action="{{ route('files.destroy', $file) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">Eliminar Archivo</button>
        </form>
    </div>
</body>
</html>
