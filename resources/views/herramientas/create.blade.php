{{-- filepath: resources/views/herramientas/create.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Herramienta</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Agregar Herramienta</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('herramientas.create') }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1">Nombre/Artículo</label>
                <input type="text" name="articulo" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Modelo</label>
                <input type="text" name="modelo" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Cantidad Disponible</label>
                <input type="number" name="cantidad" min="1" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Guardar Herramienta
                </button>
            </div>
        </form>
    </div>
</body>
</html>