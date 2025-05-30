@extends('layouts.app')

@section('content')
    <div class="overflow-x-auto" >
        <div class="container mx-auto px-4 py-8" >
            <div>
                <h1 class="text-2xl font-bold mb-6 text-center text-[#321F01]">Listado de Herramientas</h1>
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
            <table class="min-w-full divide-y divide-blue-200 shadow-xl transition-all duration-300 rounded-2xl"
                style="background-color: #FFF9F2; color: #321F01; border: 5px solid #321F01; border-radius: 1rem; overflow: hidden;">
                <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Estatus</th>
                        <th class="px-4 py-2">Artículo</th>
                        <th class="px-4 py-2">Unidad</th>
                        <th class="px-4 py-2">Modelo</th>
                        <th class="px-4 py-2">Número de Serie</th>
                        <th class="px-4 py-2">Costo</th>
                        <th class="px-4 py-2">Acciones </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($herramientas as $herramienta)
                        <tr>
                            <td>{{ $herramienta->id }}</td>
                            <td>{{ $herramienta->estatus }}</td>
                            <td>{{ $herramienta->articulo }}</td>
                            <td>{{ $herramienta->unidad }}</td>
                            <td>{{ $herramienta->modelo }}</td>
                            <td>{{ $herramienta->num_serie }}</td>
                            <td>${{ number_format($herramienta->costo, 2) }}</td>
                            <td>
                                <div class="flex justify-center items-center space-x-4">
                                    <flux:button icon="eye" size="sm"
                                        href="{{ route('herramientas.show', $herramienta->id) }}" />
                                    <span class="border-blue-300 h-6 mx-1"></span>
                                    <flux:button icon="pencil-square" size="sm"
                                        href="{{ route('herramientas.edit', $herramienta->id) }}" />
                                    <span class="border-blue-300 h-6 mx-1"></span>
                                    <form action="{{ route('herramientas.baja', $herramienta->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <flux:button icon="trash" size="sm" type="submit" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

            </table>
        </div>
    </div>
@endsection