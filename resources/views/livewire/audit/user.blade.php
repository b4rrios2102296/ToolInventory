@extends('layouts.app')
@fluxAppearance

@section('content')

    <div class="overflow-x-auto">
        <div class="container mx-auto px-4 py-8">

            <h1 class="text-2xl font-bold mb-6 text-center">
                Historial de Acciones de Usuarios</h1>

            <flux:separator />
            <br>
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-2">
                    <flux:tooltip content="PDF">
                        <flux:button icon="document-arrow-down" icon:variant="outline" href="{{ route('acciones.pdf') }}" />
                    </flux:tooltip>
                    <flux:separator vertical />
                    <flux:tooltip content="Excel">
                        <flux:button icon="document-chart-bar" icon:variant="outline"
                            href="{{ route('acciones.excel') }}" />
                    </flux:tooltip>
                </div>
                <!-- Filtro de búsqueda -->
                <div class="w-64">

                    <flux:input type="search" id="searchInput" name="search" placeholder="Buscar registros..."
                        value="{{ request('search') }}" icon="magnifying-glass" />
                </div>
            </div>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-4 text-center">Id</th>
                        <th class="px-6 py-4 text-center">Usuario</th>
                        <th class="px-6 py-4 text-center">Acción</th>
                        <th class="px-6 py-4 text-center">Folio</th>
                        <th class="px-6 py-4 text-center">Comentarios</th>
                        <th class="px-6 py-4 text-center">Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acciones as $accion)
                        <tr class="border-b border-gray-300 last:border-0">
                            <td class="px-6 py-4 text-center align-middle">{{ $accion->id}}</td>
                            <td class="px-6 py-4 text-center align-middle">{{ $accion->nombre }} {{ $accion->apellidos }}</td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if($accion->accion == 'Creado')
                                    <flux:badge color="teal" variant="solid" class="inline-block">
                                        {{ $accion->accion }}
                                    </flux:badge>
                                @elseif($accion->accion == 'Cancelado')
                                    <flux:badge color="red" variant="solid" class="inline-block">
                                        {{ $accion->accion }}
                                    </flux:badge>
                                @else
                                    {{ $accion->accion }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                <flux:link variant="subtle" href="{{ route('resguardos.show', $accion->resguardo_id) }}">
                                    {{ $accion->resguardo_id }}
                                </flux:link>
                            </td>
                            <td class="px-6 py-4 text-center align-middle">{{ $accion->comentarios }}</td>
                            <td class="px-6 py-4 text-center align-middle">
                                {{ \Carbon\Carbon::parse($accion->created_at)->setTimezone('America/Cancun')->format('d/m/Y h:i A') }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>


            <!-- Pagination aligned to the bottom-right -->
            @if($acciones->hasPages())
                <div class="mt-4 pagination-container">
                    {{ $acciones->links() }}
                </div>
            @endif

        </div>
@endsection
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            let searchTimer;

            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(function () {
                    const searchValue = searchInput.value;

                    fetch(`{{ route('acciones') }}?search=${encodeURIComponent(searchValue)}`)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newTable = doc.querySelector('tbody');
                            const newPagination = doc.querySelector('.pagination');

                            document.querySelector('tbody').innerHTML = newTable.innerHTML;
                            if (newPagination) {
                                document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
                            }
                        });
                }, 500);
            });
        });
    </script>