{{-- filepath: resources/views/resguardos/index.blade.php --}}

@extends('layouts.app')
<div class="overflow-x-auto">
    <div class="container mx-auto px-4 py-8">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-center">Listado de Resguardos</h1>
            <flux:button icon="plus-circle" href="{{ route('resguardos.create') }}">Nuevo Resguardo</flux:button>
        </div>
        <br>
        <flux:separator />
        <flux:separator />
        <br>
        <div>
            <flux:tooltip content="PDF">
                <flux:button icon="document-arrow-down" icon:variant="outline" />
            </flux:tooltip>
            <flux:tooltip content="Excel">
                <flux:button icon="document-chart-bar" icon:variant="outline" />
            </flux:tooltip>
        </div>
        <br>
        <table
            class="min-w-full divide-y divide-blue-200 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 rounded-xl shadow-xl transition-all duration-300">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
                <tr>
                    <th class="px-4 py-2">Folio</th>
                    <th class="px-4 py-2">Estatus</th>
                    <th class="px-4 py-2">Herramienta</th>
                    <th class="px-4 py-2">Colaborador</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Fecha de Resguardo</th>
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