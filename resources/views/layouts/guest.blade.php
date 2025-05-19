<!DOCTYPE html>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="min-h-screen flex items-center justify-center p-4">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
<style>
    body {
  width: 100%;
  height: 1080px;
  background: rgba(0,0,0,1);
  opacity: 1;
  position: absolute;
  top: 0px;
  left: 0px;
  overflow: hidden;
    }
</style>