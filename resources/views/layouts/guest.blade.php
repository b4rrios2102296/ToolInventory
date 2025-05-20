<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background-image: url('/Images/workshop-4863393_1280.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #000; /* Respaldo si la imagen no carga */
            position: relative; /* Para el posicionamiento del pseudo-elemento */
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: -1; /* Para que no cubra el contenido */
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>