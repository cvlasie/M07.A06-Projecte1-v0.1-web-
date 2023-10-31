<!DOCTYPE html>
<html>
<head>
    <title>Editar Archivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white rounded p-8 shadow-lg">
        <h1 class="text-2xl font-semibold mb-6">Editar Archivo</h1>

        <!-- Mostrar detalles del archivo aquí -->
        <p class="mb-4">Nombre del Archivo: {{ $file->filepath }}</p>
        <p class="mb-6">Tamaño del Archivo: {{ $file->filesize }} bytes</p>

        <!-- Formulario para actualizar el archivo -->
        <form action="{{ route('files.update', $file) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="newFile" class="block text-gray-700 font-bold mb-2">Seleccionar un nuevo archivo:</label>
                <input type="file" name="newFile" id="newFile" class="w-full p-2 border rounded" />
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Actualizar Archivo</button>
            </div>
        </form>
    </div>
</body>
</html>
