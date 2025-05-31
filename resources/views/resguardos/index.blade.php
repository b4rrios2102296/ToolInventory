@extends('layouts.app')

<div class="overflow-x-auto">
    <div class="container mx-auto px-4 py-8">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-center text-[#321F01]">
                Listado de Resguardos
            </h1>
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
        <table class="min-w-full divide-y divide-blue-200 shadow-xl transition-all duration-300 rounded-2xl"
            style="background-color: #FFF9F2; color: #321F01; border: 5px solid #321F01; border-radius: 1rem; overflow: hidden;">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
                <tr>
                    <th class="px-4 py-2">Folio</th>
                    <th class="px-4 py-2">Estatus</th>
                    <th class="px-4 py-2">Realizó Resguardo</th>
                    <th class="px-4 py-2">Asignado a</th>
                    <th class="px-4 py-2">Colaborador</th>
                    <th class="px-4 py-2">Fecha de Resguardo</th>
                    <th class="px-4 py-2">Detalle de Resguardo</th>
                    <th class="px-4 py-2">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resguardos as $resguardo)
                    <tr
                        class="border-t text-center 
                        {{ $resguardo->estatus == 'Cancelado' ? 'bg-gray-100 text-gray-500' : 'bg-white text-black' }}">
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ $resguardo->folio }}</s>
                            @else
                                {{ $resguardo->folio }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:badge color="{{ $resguardo->estatus == 'Cancelado' ? 'zinc' : 'green' }}"
                                class="text-white">
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
                                                    {{ $detalle->costo ? '$' . number_format($detalle->costo, 2) : 'N/A' }}</s>
                                            @else
                                                <span class="font-semibold">Costo:</span>
                                                {{ $detalle->costo ? '$' . number_format($detalle->costo, 2) : 'N/A' }}
                                            @endif
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:dropdown class="relative">
                                <flux:button icon:trailing="chevron-down" class="px-4 py-2 rounded-md transition-all">
                                    Acciones
                                </flux:button>
                                <flux:menu
                                    class="absolute right-0 w-48 bg-white shadow-lg rounded-md py-2 z-10 border border-gray-300">
                                    <flux:menu.item icon="eye" kbd="⌘V"
                                        class="px-4 py-2 hover:bg-gray-100 transition-all">
                                        <a href="{{ route('resguardos.show', $resguardo->folio) }}"
                                            class="block text-gray-700">Ver</a>
                                    </flux:menu.item>
                                    <flux:menu.item icon="pencil-square" kbd="⌘E"
                                        class="px-4 py-2 hover:bg-gray-100 transition-all">
                                        <a href="{{ route('resguardos.edit', $resguardo->folio) }}"
                                            class="block text-gray-700">Editar</a>
                                    </flux:menu.item>
                                    @if ($resguardo->estatus == 'Resguardo')
                                        <div>
                                            <form action="{{ route('resguardos.cancel', $resguardo->folio) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas cancelar este resguardo?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estatus" value="Cancelado">
                                                <flux:menu.item type="submit" icon="x-circle" kbd="⌘⌫"
                                                    class="px-4 py-2 hover:bg-red-100 transition-all" variant="danger">
                                                    Cancelar
                                                </flux:menu.item>
                                            </form>
                                        </div>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No hay resguardos registrados.</td>
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
