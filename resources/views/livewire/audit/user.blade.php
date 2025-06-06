@extends('layouts.app')
@fluxAppearance

@section(section: 'content')

    <div class="overflow-x-auto">
        <h1 class="text-2xl font-bold mb-6 text-center">
            Historial de Acciones de Usuarios</h1>

        <flux:separator />
        <flux:separator />
        <br>
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-2">
                <flux:tooltip content="PDF">
                    <flux:button icon="document-arrow-down" icon:variant="outline" href="{{ route('resguardos.pdf') }}" />
                </flux:tooltip>
                <flux:tooltip content="Excel">
                    <flux:button icon="document-chart-bar" icon:variant="outline" href="{{ route('resguardos.excel') }}" />
                </flux:tooltip>
            </div>
            <!-- Filtro de búsqueda -->
            <div class="w-64">
                <flux:input type="search" id="searchInput" name="search" placeholder="Buscar registros..."
                    value="{{ request('search') }}" icon="magnifying-glass" />
            </div>
            {{ $acciones->links() }}
        </div>
        <table>
            <thead>
                <tr>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Acción</th>
                    <th class="px-4 py-2">folio</th>
                    <th class="px-4 py-2">Comentarios</th>
                    <th class="px-4 py-2">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acciones as $accion)
                    <tr>
                        <td class="px-4 py-2">{{ $accion->nombre }} {{ $accion->apellidos }}</td>
                        <td class="px-4 py-2">{{ $accion->accion }}</td>
                        <td class="px-4 py-2">{{ $accion->resguardo_id }}</td>
                        <td class="px-4 py-2">{{ $accion->comentarios }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

@endsection