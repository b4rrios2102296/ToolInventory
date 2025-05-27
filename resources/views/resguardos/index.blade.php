{{-- filepath: resources/views/resguardos/index.blade.php --}}

@extends('layouts.app')
<div class="overflow-x-auto">
    <div class="container mx-auto px-4 py-8">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-center">Listado de Resguardos</h1>
            <flux:button icon="plus-circle" href="{{ route(name: 'resguardos.create') }}">Nuevo Resguardo</flux:button>
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
            class="min-w-full divide-y divide-blue-200 shadow-xl transition-all duration-300 rounded-2xl"
            style="background-color: #FFF9F2; color: #321F01; border: 5px solid #321F01; border-radius: 1rem; overflow: hidden;">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
                <tr>
                    <th class="px-4 py-2">Folio</th>
                    <th class="px-4 py-2">Prioridad</th>
                    <th class="px-4 py-2">Estatus</th>
                    <th class="px-4 py-2">Realizó Resguardo</th>
                    <th class="px-4 py-2">Asignado a </th>
                    <th class="px-4 py-2">Colaborador</th>
                    <th class="px-4 py-2">Fecha de Resguardo</th>
                    <th class="px-4 py-2">Detalle de Resguardo</th>
                    <th class="px-4 py-2">Opciones</th>

                </tr>
            </thead>
            <tbody>
                @forelse($resguardos as $resguardo)
                    <tr class="border-t text-center">
                        <td class="px-4 py-2">{{ $resguardo->folio }}</td>
                        <td class="px-4 py-2">{{ $resguardo->prioridad }}</td>
                        <td class="px-4 py-2">{{ $resguardo->estatus }}</td>
                        <td class="px-4 py-2">
                            {{ $resguardo->aperturo_nombre ?? '' }} {{ $resguardo->aperturo_apellidos ?? '' }}
                        </td>
                        <td class="px-4 py-2">{{ $resguardo->colaborador_nombre ?? '' }}</td>
                        <td class="px-4 py-2">{{ $resguardo->colaborador_num }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $detalles = json_decode($resguardo->detalles_resguardo ?? '[]');
                                if (is_object($detalles))
                                    $detalles = [$detalles];
                            @endphp
                            @if(!empty($detalles))
                                <ul class="space-y-2 text-center">
                                    @foreach($detalles as $detalle)
                                        <div><span class="font-semibold">ID:</span> {{ $detalle->id ?? '' }}</div>
                                        <div><span class="font-semibold">Articulo:</span> {{ $detalle->articulo ?? '' }}</div>
                                        <div><span class="font-semibold">Modelo:</span> {{ $detalle->modelo ?? '' }}</div>
                                        <div><span class="font-semibold">Núm. Serie:</span> {{ $detalle->num_serie ?? '' }}</div>
                                        <div><span class="font-semibold">Cantidad:</span> {{ $detalle->cantidad ?? '' }}</div>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down" >Acciones</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye" kbd="⌘V">Ver</flux:menu.item>
                                    <flux:menu.item icon="pencil-square" kbd="⌘E">Editar</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger" kbd="⌘⌫">Cancelar</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
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