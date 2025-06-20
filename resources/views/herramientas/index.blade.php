@extends('layouts.app')
@fluxAppearance

@section('content')



@if(session('success') || session('error'))
<div id="toast-container" class="fixed top-4 right-4 z-50 transition-all duration-500 ease-in-out">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-lg toast-message">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 shadow-lg toast-message">
            {{ session('error') }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastContainer = document.getElementById('toast-container');
        const toastMessages = document.querySelectorAll('.toast-message');

        // Animación de entrada
        toastContainer.style.opacity = '0';
        toastContainer.style.transform = 'translateX(100%)';
        setTimeout(() => {
            toastContainer.style.opacity = '1';
            toastContainer.style.transform = 'translateX(0)';
        }, 100);

        // Auto-cierre después de 5 segundos
        setTimeout(() => {
            toastMessages.forEach(message => {
                message.style.opacity = '0';
                message.style.transform = 'translateX(100%)';
                message.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            });
            setTimeout(() => toastContainer.remove(), 500);
        }, 5000);

        // Cierre manual al hacer clic
        toastMessages.forEach(message => {
            message.addEventListener('click', function() {
                this.style.opacity = '0';
                this.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (toastContainer.querySelectorAll('.toast-message').length === 1) {
                        toastContainer.remove();
                    } else {
                        this.remove();
                    }
                }, 500);
            });
        });
    });
</script>
@endif



    <div class="overflow-x-auto">
        <div class="container mx-auto px-4 py-8">
            <div>
                <h1 class="text-2xl font-bold mb-6 text-center">Listado de Herramientas</h1>
                @if(!Auth::user()->hasPermission('read_access'))
                    <flux:button icon="plus-circle" href="{{ route('herramientas.create') }}">
                        Nueva Herramienta
                    </flux:button>
                @endif
            </div>
            <br>
            <flux:separator />
            <br>
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-2">
                    <flux:tooltip content="PDF">
                        <flux:button icon="document-arrow-down" icon:variant="outline"
                            href="{{ route('herramientas.pdf') }}" />
                    </flux:tooltip>
                    <flux:separator vertical />
                    <flux:tooltip content="Excel">
                        <flux:button icon="document-chart-bar" icon:variant="outline"
                            href="{{ route('herramientas.excel') }}" />
                    </flux:tooltip>
                </div>

                <!-- Filtro de búsqueda -->
                <div class="w-64">
                    <form action="{{ route('herramientas.index') }}" method="GET" id="searchForm">
                        <flux:input type="search" id="searchInput" name="search" placeholder="Buscar herramientas..."
                            value="{{ $search }}" icon="magnifying-glass" />
                    </form>
                </div>
            </div>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-center">Estatus</th>
                        <th class="px-6 py-4 text-center">Artículo</th>
                        <th class="px-6 py-4 text-center">Unidad</th>
                        <th class="px-6 py-4 text-center">Modelo</th>
                        <th class="px-6 py-4 text-center">Número de Serie</th>
                        <th class="px-6 py-4 text-center">Costo</th>
                        <th class="px-6 py-4 text-center">Observaciones</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($herramientas as $herramienta)
                        <tr
                            class="border-b border-gray-300 last:border-0 text-center  {{ $herramienta->estatus == 'Baja' ? 'text-gray-500' : '' }}">
                            <td class="px-6 py-4 whitespace-normal break-all max-w-xs text-center align-middle herramienta-id">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->id }}</s>
                                @else
                                    {{ $herramienta->id }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if($herramienta->estatus == 'Resguardo')
                                    @php
                                        $resguardo = DB::connection('toolinventory')
                                            ->table('resguardos')
                                            ->where('detalles_resguardo', 'like', '%"id":"' . $herramienta->id . '"%')
                                            ->where('estatus', 'Resguardo')
                                            ->first();
                                    @endphp
                                    @if($resguardo)
                                        <a href="{{ route('resguardos.show', $resguardo->folio) }}">
                                            <flux:badge color="teal" variant="solid">
                                                Resguardo
                                            </flux:badge>
                                        </a>
                                    @else
                                        <flux:badge variant="solid" color="red">Cancelado</flux:badge>
                                    @endif
                                @else
                                    <flux:badge variant="solid" color="{{ $herramienta->estatus == 'Baja' ? 'red' : 'green' }}">
                                        @if($herramienta->estatus == 'Baja')
                                            <s>{{ $herramienta->estatus }}</s>
                                        @else
                                            {{ $herramienta->estatus }}
                                        @endif
                                    </flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->articulo }}</s>
                                @else
                                    {{ $herramienta->articulo }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->unidad }}</s>
                                @else
                                    {{ $herramienta->unidad }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-normal break-all max-w-xs text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->modelo }}</s>
                                @else
                                    {{ $herramienta->modelo }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->num_serie }}</s>
                                @else
                                    {{ $herramienta->num_serie }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) . ' MXN' : 'N/A' }}</s>
                                @else
                                    {{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) . ' MXN' : 'N/A' }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if(!empty($herramienta->observaciones))
                                    @if($herramienta->estatus == 'Baja')
                                        <s>{{ Str::limit($herramienta->observaciones, 50) }}</s>
                                    @else
                                        <div class="tooltip" data-tip="{{ $herramienta->observaciones }}">
                                            {{ Str::limit($herramienta->observaciones, 50) }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                <flux:dropdown>
                                    <flux:button icon:trailing="ellipsis-horizontal"></flux:button>

                                    <flux:menu>
                                        <a href="{{ route('herramientas.show', $herramienta->id) }}">
                                            <flux:menu.item icon="eye" kbd="⌘V">Ver</flux:menu.item>
                                        </a>

                                        @if ($herramienta->estatus == 'Disponible' && !auth()->user()->hasPermission('read_access'))
                                            <a href="{{ route('herramientas.edit', $herramienta->id) }}">
                                                <flux:menu.item icon="pencil-square" kbd="⌘E">Editar</flux:menu.item>
                                            </a>
                                            <!-- Trigger Modal for "Dar de Baja" -->
                                            <flux:modal.trigger name="baja-herramienta-{{ $herramienta->id }}">
                                                <flux:menu.item icon="x-circle" variant="danger" kbd="⌘⌫">
                                                    Dar de Baja
                                                </flux:menu.item>
                                            </flux:modal.trigger>
                                        @endif

                                        @if ($herramienta->estatus == 'Baja' && auth()->user()->hasPermission('user_audit'))
                                            <!-- Trigger Modal for "Eliminar Herramienta" -->
                                            <flux:modal.trigger name="eliminar-herramienta-{{ $herramienta->id }}">
                                                <flux:menu.item icon="trash" variant="danger">
                                                    Eliminar Herramienta
                                                </flux:menu.item>
                                            </flux:modal.trigger>
                                        @endif
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>

                        <!-- Modal for "Dar de Baja" -->
                        <flux:modal name="baja-herramienta-{{ $herramienta->id }}" class="md:w-96">
                            <div class="space-y-6">
                                <flux:heading size="lg">Dar de Baja Herramienta</flux:heading>
                                <flux:text class="mt-2">Por favor, ingresa el motivo de la baja.</flux:text>
                                <form action="{{ route('herramientas.baja', $herramienta->id) }}" method="POST"
                                    id="bajaForm-{{ $herramienta->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estatus" value="Baja">
                                    <flux:textarea label="Motivo" name="observaciones" placeholder="Escribe el motivo aquí..."
                                        required class="mb-4" />
                                    <div class="flex mt-4">
                                        <flux:spacer />
                                        <flux:button type="submit" variant="primary">Confirmar</flux:button>
                                    </div>
                                </form>
                            </div>
                        </flux:modal>

                        <!-- Modal for "Eliminar Herramienta" -->
                        <flux:modal name="eliminar-herramienta-{{ $herramienta->id }}" class="md:w-96">
                            <div class="space-y-6">
                                <flux:heading size="lg">Eliminar Herramienta</flux:heading>
                                <flux:text class="mt-2">¿Seguro que quieres eliminarlo? esta acción es irreversible
                                </flux:text>
                                <form action="{{ route('herramientas.delete', $herramienta->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex mt-4">
                                        <flux:spacer />
                                        <flux:button type="submit" variant="danger"
                                            style="background-color:#dc2626 !important; color:white !important">
                                            Eliminar
                                        </flux:button>
                                </form>
                            </div>
                        </flux:modal>

                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center">No hay herramientas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($herramientas->hasPages())
                <div class="mt-4 pagination-container">
                    {{ $herramientas->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            let searchTimer;

            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(function () {
                    const searchValue = searchInput.value;

                    fetch(`{{ route('herramientas.index') }}?search=${encodeURIComponent(searchValue)}`)
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
@endsection