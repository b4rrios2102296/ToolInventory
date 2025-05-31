@extends('layouts.app')

@section('content')
    <div class="overflow-x-auto">
        <div class="container mx-auto px-4 py-8">
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
                    @forelse($herramientas as $herramienta)
                        <tr class="border-t">
                            <td class="px-4 py-2 whitespace-normal break-all max-w-xs text-center align-middle">
                                {{ $herramienta->id }}
                            </td>
                            <td class="px-4 py-2">{{ $herramienta->estatus }}</td>
                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->articulo }}</td>
                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->unidad }}</td>
                            <td class="px-4 py-2 whitespace-normal break-all max-w-xs text-center align-middle">
                                {{ $herramienta->modelo }}
                            </td>
                            <td class="px-4 py-2 text-center align-middle">{{ $herramienta->num_serie }}</td>
                            <td class="px-4 py-2 text-center align-middle">
                                {{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}
                            <td class="px-4 py-2 text-center align-middle">
                                <flux:dropdown>
                                    <flux:button icon:trailing="ellipsis-horizontal"></flux:button>

                                    <flux:menu>
                                        <a href="{{ route('herramientas.show', $herramienta->id) }}">
                                            <flux:menu.item icon="eye" kbd="⌘V">Ver</flux:menu.item>
                                        </a>
                                        <a href="{{ route('herramientas.edit', $herramienta->id) }}">
                                            <flux:menu.item icon="pencil-square" kbd="⌘E">Editar</flux:menu.item>
                                        </a>



                                        <form action="{{ route('herramientas.baja', $herramienta->id) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas dar de baja esta herramienta?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estatus" value="Baja">
                                            <flux:menu.item type="submit" icon="x-circle" variant="danger" kbd="⌘⌫">
                                                Dar de Baja
                                            </flux:menu.item>
                                        </form>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No hay herramientas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Estilos específicos para la tabla */
        .container table tbody tr:not(.bg-gray-100) {
            background-color: #FFF9F2 !important;
        }

        /* Estilos para los botones Flux con mayor especificidad */
        div.container flux-button {
            --flux-button-bg: #321F01 !important;
            --flux-button-text: #FFF9F2 !important;
            --flux-button-border: none !important;
            --flux-button-hover-bg: rgba(255, 249, 242, 0.74) !important;
            --flux-button-hover-text: #321F01 !important;
            --flux-button-active-bg: #1a1300 !important;
        }

        /* Estilos para el dropdown */
        div.container .relative flux-button {
            background-color: #321F01 !important;
            color: #FFF9F2 !important;
            border: none !important;
        }

        div.container .relative flux-button:hover {
            background-color: rgba(255, 249, 242, 0.74) !important;
            color: #321F01 !important;
        }

        /* Badges - mantener colores pero forzar texto blanco */
        div.container flux-badge {
            --flux-badge-text: white !important;
        }
    </style>
@endsection