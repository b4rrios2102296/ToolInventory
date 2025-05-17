<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Dashboard</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">ToolInventory</span>
                </div>
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Dashboard de Herramientas</h1>

 <!-- Livewire Component -->
    </main>

    @livewireScripts
</body>
</html>
