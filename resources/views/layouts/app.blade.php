
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('titulo', 'BYTE & CRUNCH')</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-orange-50 text-stone-900">

    @yield('content')

    @stack('scripts')
</body>
</html>
