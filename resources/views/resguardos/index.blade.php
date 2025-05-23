{{-- filepath: resources/views/resguardos/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Resguardos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Resguardos</h1>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-4">
            <a href="{{ route('resguardos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nuevo Resguardo</a>
        </div>
        <div class="bg-white rounded shadow p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Folio</th>
                        <th class="px-4 py-2">Estatus</th>
                        <th class="px-4 py-2">Herramienta</th>
                        <th class="px-4 py-2">Colaborador</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Fecha Entrega</th>
                        <th class="px-4 py-2">Prioridad</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resguardos as $resguardo)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $resguardo->folio }}</td>
                            <td class="px-4 py-2">{{ $resguardo->estatus }}</td>
                            <td class="px-4 py-2">{{ $resguardo->herramienta_id }}</td>
                            <td class="px-4 py-2">{{ $resguardo->colaborador_num }}</td>
                            <td class="px-4 py-2">{{ $resguardo->cantidad }}</td>
                            <td class="px-4 py-2">{{ $resguardo->fecha_captura }}</td>
                            <td class="px-4 py-2">{{ $resguardo->prioridad }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay resguardos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>