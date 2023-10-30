<div class="container">
    <h1>Detalles del Archivo</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nombre del Archivo: {{ $file->filepath }}</h5>
            <p class="card-text">Tamaño del Archivo: {{ $file->filesize }} bytes</p>
            <p class="card-text">URL del Archivo: <a href="{{ $fileUrl }}" target="_blank">{{ $fileUrl }}</a></p>

            <img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" />
    </div>

    <br>

    <a href="{{ route('files.edit', $file) }}" class="btn btn-primary">Editar Archivo</a>

    <form method="post" action="{{ route('files.destroy', $file) }}" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">Eliminar Archivo</button>
    </form>
</div>
