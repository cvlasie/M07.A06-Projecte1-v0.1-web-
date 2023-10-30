<!DOCTYPE html>
<html>
<head>
    <title>Subir Archivo</title>
</head>
<body>
    <!--
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    -->
    <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="upload">Archivo:</label>
            <input type="file" class="form-control" name="upload"/>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <button type="reset" class="btn btn-secondary">Restablecer</button>
    </form>
</body>
</html>