@extends('layouts.app')
@fluxAppearance
@section('content')
<div class="overflow-x-auto">
    <div class="container mx-auto px-4 py-8">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-center">
                Listado de Resguardos
            </h1>

            @if(!Auth::user()->hasPermission('read_access'))
                <flux:button icon="plus-circle" href="{{ route('resguardos.create') }}">
                    Nuevo Resguardo
                </flux:button>
            @endif
        </div>
        <br>
        <flux:separator/>
        <br>
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-2">
                <flux:tooltip content="PDF">
                    <flux:button icon="document-arrow-down" icon:variant="outline"
                        href="{{ route('resguardos.pdf') }}" />
                </flux:tooltip>
                <flux:separator vertical/>
                <flux:tooltip content="Excel">
                    <flux:button icon="document-chart-bar" icon:variant="outline"
                        href="{{ route('resguardos.excel') }}" />
                </flux:tooltip>
            </div>

            <!-- Filtro de búsqueda -->
            <div class="w-64">
                <flux:input type="search" id="searchInput" name="search" placeholder="Buscar resguardos..."
                    value="{{ request('search') }}" icon="magnifying-glass" />
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="px-4 py-2">Folio</th>
                    <th class="px-4 py-2">Estatus</th>
                    <th class="px-4 py-2">Realizó Resguardo</th>
                    <th class="px-4 py-2">Asignado a</th>
                    <th class="px-4 py-2">Colaborador</th>
                    <th class="px-4 py-2">Fecha de Resguardo</th>
                    <th class="px-4 py-2">Detalle de Resguardo</th>
                    <th class="px-4 py-2">Comentarios</th> <!-- Nueva columna -->
                    <th class="px-4 py-2">Opciones</th>
                </tr>
            </thead>
            </thead>
            <tbody>
                @forelse($resguardos as $resguardo)
                    <tr class="border-t text-center {{ $resguardo->estatus == 'Cancelado' ? ' text-gray-500' : '' }}">
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ $resguardo->folio }}</s>
                            @else
                                {{ $resguardo->folio }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:badge variant="solid" color="{{ $resguardo->estatus == 'Cancelado' ? 'red' : 'teal' }}">
                                @if ($resguardo->estatus == 'Cancelado')
                                    <s>{{ $resguardo->estatus }}</s>
                                @else
                                    {{ $resguardo->estatus }}
                                @endif
                            </flux:badge>
                        </td>
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ $resguardo->aperturo_nombre ?? '' }}
                                    {{ $resguardo->aperturo_apellidos ?? '' }}</s>
                            @else
                                {{ $resguardo->aperturo_nombre ?? '' }} {{ $resguardo->aperturo_apellidos ?? '' }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ $resguardo->colaborador_nombre ?? '' }}</s>
                            @else
                                {{ $resguardo->colaborador_nombre ?? '' }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ $resguardo->colaborador_num }}</s>
                            @else
                                {{ $resguardo->colaborador_num }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}</s>
                            @else
                                {{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $detalles = json_decode($resguardo->detalles_resguardo ?? '[]');
                                if (is_object($detalles)) {
                                    $detalles = [$detalles];
                                }
                            @endphp
                            @if (!empty($detalles))
                                <ul class="space-y-2 text-center">
                                    @foreach ($detalles as $detalle)
                                        <div>
                                            @if ($resguardo->estatus == 'Cancelado')
                                                <s><span class="font-semibold">ID:</span> {{ $detalle->id ?? '' }}</s>
                                            @else
                                                <span class="font-semibold">ID:</span> {{ $detalle->id ?? '' }}
                                            @endif
                                        </div>
                                        <div>
                                            @if ($resguardo->estatus == 'Cancelado')
                                                <s><span class="font-semibold">Artículo:</span>
                                                    {{ $detalle->articulo ?? '' }}</s>
                                            @else
                                                <span class="font-semibold">Artículo:</span>
                                                {{ $detalle->articulo ?? '' }}
                                            @endif
                                        </div>
                                        <div>
                                            @if ($resguardo->estatus == 'Cancelado')
                                                <s><span class="font-semibold">Modelo:</span>
                                                    {{ $detalle->modelo ?? '' }}</s>
                                            @else
                                                <span class="font-semibold">Modelo:</span> {{ $detalle->modelo ?? '' }}
                                            @endif
                                        </div>
                                        <div>
                                            @if ($resguardo->estatus == 'Cancelado')
                                                <s><span class="font-semibold">Núm. Serie:</span>
                                                    {{ $detalle->num_serie ?? '' }}</s>
                                            @else
                                                <span class="font-semibold">Núm. Serie:</span>
                                                {{ $detalle->num_serie ?? '' }}
                                            @endif
                                        </div>
                                        <div>
                                            @if ($resguardo->estatus == 'Cancelado')
                                                <s><span class="font-semibold">Costo:</span>
                                                 {{ $detalle->costo ? '$' . number_format($detalle->costo, 2) . ' MXN' : 'N/A' }}</s>
                                                @else
                                                <span class="font-semibold">Costo:</span>
                                                {{ $detalle->costo ? '$' . number_format($detalle->costo, 2) . ' MXN' : 'N/A' }}
                                                @endif
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <!-- Nueva celda para comentarios -->
                        <td class="px-4 py-2">
                            @if($resguardo->comentarios)
                                @if ($resguardo->estatus == 'Cancelado')
                                    <s>{{ Str::limit($resguardo->comentarios, 50) }}</s>
                                @else
                                    {{ Str::limit($resguardo->comentarios, 50) }}
                                @endif
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down"> Acciones </flux:button>

                                <flux:menu>
                                    <a href="{{ route('resguardos.show', $resguardo->folio) }}">
                                        <flux:menu.item icon="eye" kbd="⌘V">Ver</flux:menu.item>
                                    </a>

                                    @if ($resguardo->estatus == 'Resguardo' && !auth()->user()->hasPermission('read_access'))
                                        <!-- Trigger Modal for "Cancelar Resguardo" -->
                                        <flux:modal.trigger name="cancelar-resguardo-{{ $resguardo->folio }}">
                                            <flux:menu.item icon="x-circle" variant="danger" kbd="⌘⌫">
                                                Cancelar
                                            </flux:menu.item>
                                        </flux:modal.trigger>
                                    @elseif ($resguardo->estatus == 'Cancelado' && auth()->user()->hasPermission('user_audit'))
                                        <!-- Trigger Modal for "Eliminar Resguardo" -->
                                        <flux:modal.trigger name="eliminar-resguardo-{{ $resguardo->folio }}">
                                            <flux:menu.item icon="trash" variant="danger">
                                                Eliminar Resguardo
                                            </flux:menu.item>
                                        </flux:modal.trigger>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>

                            <!-- Modal for "Cancelar Resguardo" -->
                            <!-- Modal for "Cancelar Resguardo" -->
                            <flux:modal name="cancelar-resguardo-{{ $resguardo->folio }}" class="md:w-96">
                                <div class="space-y-6">
                                    <flux:heading size="lg">Cancelar Resguardo</flux:heading>
                                    <flux:text class="mt-2">Por favor, ingresa el motivo de la cancelación.</flux:text>
                                    <form action="{{ route('resguardos.cancel', $resguardo->folio) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="estatus" value="Cancelado">
                                        <flux:textarea label="Motivo" name="comentarios"
                                            placeholder="Escribe el motivo aquí..." required class="mb-4" />
                                        <div class="flex mt-4">
                                            <flux:spacer />
                                            <flux:button type="submit" variant="primary">Confirmar</flux:button>
                                        </div>
                                    </form>
                                </div>
                            </flux:modal>

                            <!-- Modal for "Eliminar Resguardo" -->
                            <flux:modal name="eliminar-resguardo-{{ $resguardo->folio }}" class="md:w-96">
                                <div class="space-y-6">
                                    <flux:heading size="lg">Eliminar Resguardo</flux:heading>
                                    <form action="{{ route('resguardos.delete', $resguardo->folio) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <flux:text class="mt-2">¿Seguro que quieres eliminarlo? esta acción es irreversible
                                        </flux:text>
                                        <div class="flex mt-4">
                                            <flux:spacer />
                                            <flux:button type="submit" variant="danger" style="all:unset !important; background-color:#dc2626 !important; color:white !important; padding:0.5rem 1.25rem !important; border-radius:0.375rem !important;">Eliminar</flux:button>
                                        </div>
                                    </form>
                                </div>
                            </flux:modal>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No hay resguardos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Agrega esto para la paginación -->
        @if($resguardos->hasPages())
            <div class="mt-4 pagination-container">
                {{ $resguardos->links() }}
            </div>
        @endif
    </div>
</div>
<script>
    // Versión alternativa con AJAX (reemplaza el script anterior)
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        let searchTimer;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                const searchValue = searchInput.value;

                fetch(`{{ route('resguardos.index') }}?search=${encodeURIComponent(searchValue)}`)
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
            },);
        });
    });
</script>
@if(session('open_pdf'))
<script>
    // Verificar si SweetAlert2 está cargado
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    } else {
        console.log('Resguardo {{ session('folio') }} creado correctamente');
    }

    // Abrir PDF en nueva pestaña
    window.open("{{ session('pdf_url') }}", '_blank');
</script>
@endif
@endsection