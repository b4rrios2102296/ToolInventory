@extends('layouts.app')

@section('content')
    <div class="overflow-x-auto">
        <div class="container mx-auto px-4 py-8">
            <div>
                <h1 class="text-2xl font-bold mb-6 text-center">Listado de Herramientas</h1>
                <flux:button icon="plus-circle" href="{{ route('herramientas.create') }}">Nueva Herramienta</flux:button>
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
                class="min-w-full divide-y divide-blue-200 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 rounded-xl shadow-xl transition-all duration-300 table-auto">
                <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Artículo</th>
                        <th class="px-4 py-2">Unidad</th>
                        <th class="px-4 py-2">Modelo</th>
                        <th class="px-4 py-2">Num Serie</th>
                        <th class="px-4 py-2">Observaciones</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($herramientas as $herramienta)
                                        <tr class="border-t">
                                            <td class="px-4 py-2 whitespace-normal break-all max-w-xs text-center align-middle">
                                                {{ $herramienta->id }}
                                            </td>
                                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->cantidad }}</td>
                                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->articulo }}</td>
                                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->unidad }}</td>
                                            <td class="px-4 py-2 whitespace-normal break-all max-w-xs text-center align-middle">
                                                {{ $herramienta->modelo }}
                                            </td>
                                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->num_serie }}</td>
                                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->observaciones }}</td>
                                            <td class="px-4 py-2 text-center align-middle">
                                                <div class="flex justify-center items-center space-x-4">
                                                    <flux:button icon="eye" size="sm" />
                                                    <span class="border-blue-300 h-6 mx-1"></span>
                                                    <flux:button icon="pencil-square" size="sm" />
                                                    <span class=" border-blue-300 h-6 mx-1"></span>
                                                    <flux:button icon="trash" size="sm" />
                                                </div>





                                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-blue-400">No hay herramientas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection