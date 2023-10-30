<div class="container">
    <h1>Editar Archivo</h1>

    <!-- Mostrar detalles del archivo aquí -->
    <p>Nombre del Archivo: {{ $file->filepath }}</p>
    <p>Tamaño del Archivo: {{ $file->filesize }} bytes</p>

    <!-- Formulario para actualizar el archivo -->
    <form action="{{ route('files.update', $file) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="newFile">Seleccionar un nuevo archivo:</label>
            <input type="file" name="newFile" id="newFile">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Archivo</button>
    </form>
</div>
