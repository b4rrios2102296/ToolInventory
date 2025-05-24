{{-- filepath: resources/views/herramientas/index.blade.php --}}
<table class="min-w-full table-auto border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="px-4 py-2 border">id</th>
            <th class="px-4 py-2 border">Cantidad</th>
            <th class="px-4 py-2 border">Artículo</th>
            <th class="px-4 py-2 border">Unidad</th>
            <th class="px-4 py-2 border">Modelo</th>
            <th class="px-4 py-2 border">Num Serie</th>
            <th class="px-4 py-2 border">Observaciones</th>

        </tr>
    </thead>
    <tbody>
        @forelse($herramientas as $herramienta)
            <tr>
                <td class="px-4 py-2 border">{{ $herramienta->id }}</td>
                <td class="px-4 py-2 border">{{ $herramienta->cantidad }}</td>
                <td class="px-4 py-2 border">{{ $herramienta->articulo }}</td>
                <td class="px-4 py-2 border">{{ $herramienta->unidad }}</td>
                <td class="px-4 py-2 border">{{ $herramienta->modelo }}</td>
                <td class="px-4 py-2 border">{{ $herramienta->num_serie }}</td>
                <td class="px-4 py-2 border">{{ $herramienta->observaciones }}</td>

                
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-4 border">No hay herramientas registradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
