<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-blue-500 p-4 text-white">
        <div class="container mx-auto">
            <!-- Agregar contenido del encabezado, como logotipo, menú, etc. -->
        </div>
    </nav>

    <div class="container mx-auto mt-4">
        @yield('content')
    </div>

</body>
</html>