@extends('layouts.app')
<div class="overflow-x-auto">
    <div class="container mx-auto px-4 py-8">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-center">
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
                <flux:button icon="document-arrow-down" icon:variant="outline" href="{{ route('resguardos.pdf') }}" />
            </flux:tooltip>
            <flux:tooltip content="Excel">
                <flux:button icon="document-chart-bar" icon:variant="outline" href="{{ route('resguardos.excel') }}" class="btn btn-success" />
            </flux:tooltip>
        </div>
        <br>
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
                    <th class="px-4 py-2">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resguardos as $resguardo)
                    <tr
                        class="border-t text-center 
                                                                    {{ $resguardo->estatus == 'Cancelado' ? ' text-gray-500' : '' }}">
                        <td class="px-4 py-2">
                            @if ($resguardo->estatus == 'Cancelado')
                                <s>{{ $resguardo->folio }}</s>
                            @else
                                {{ $resguardo->folio }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:badge color="{{ $resguardo->estatus == 'Cancelado' ? 'zinc' : 'green' }}">
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
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down"> Acciones </flux:button>

                                <flux:menu>
                                    <a href="{{ route('resguardos.show', $resguardo->folio) }}">
                                        <flux:menu.item icon="eye" kbd="⌘V">Ver</flux:menu.item>
                                    </a>
                                    <a href="{{ route('resguardos.edit', $resguardo->folio) }}">
                                        <flux:menu.item icon="pencil-square" kbd="⌘E">Editar</flux:menu.item>
                                    </a>

                                    @if ($resguardo->estatus == 'Resguardo')
                                        <form action="{{ route('resguardos.cancel', $resguardo->folio) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas cancelar este resguardo?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estatus" value="Cancelado">
                                            <flux:menu.item type="submit" icon="x-circle" variant="danger" kbd="⌘⌫">
                                                Cancelar
                                            </flux:menu.item>
                                        </form>
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

</style>