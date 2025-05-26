{{-- filepath: resources/views/herramientas/index.blade.php --}}
@extends('layouts.app')

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-blue-200 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 rounded-xl shadow-xl transition-all duration-300">
        <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tl-xl">ID</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Cantidad</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Artículo</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Unidad</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Modelo</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Num Serie</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tr-xl">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($herramientas as $herramienta)
                <tr class="hover:bg-blue-200/60 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->cantidad }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->articulo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->unidad }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->modelo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->num_serie }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $herramienta->observaciones }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-blue-400">No hay herramientas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
