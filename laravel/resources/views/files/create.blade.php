<!DOCTYPE html>
<html>
<head>
    <title>Subir Archivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white rounded p-8 shadow-lg">
        <h1 class="text-2xl font-semibold mb-6">Subir Archivo</h1>

        @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="upload" class="block text-gray-700 font-bold mb-2">Archivo:</label>
                <input type="file" class="w-full p-2 border rounded" name="upload" id="upload" />
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Crear</button>
                <button type="reset" class="px-4 py-2 bg-gray-400 text-gray-800 rounded hover:bg-gray-500">Restablecer</button>
            </div>
        </form>
    </div>
</body>
</html>
