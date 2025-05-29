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
        <table class="min-w-full divide-y divide-blue-200 shadow-xl transition-all duration-300 rounded-2xl"
            style="background-color: #FFF9F2; color: #321F01; border: 5px solid #321F01; border-radius: 1rem; overflow: hidden;">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500">
                <tr>
                    <th class="px-4 py-2">Folio</th>
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
                                        <div><span class="font-semibold">Costo:</span>
                                            {{ $detalle->costo ? '$' . number_format($detalle->costo, 2) : 'N/A' }}</div>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <flux:dropdown class="relative">
                                <flux:button icon:trailing="chevron-down"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                                    Acciones</flux:button>
                                <flux:menu
                                    class="absolute right-0 w-48 bg-white shadow-lg rounded-md py-2 z-10 border border-gray-300">
                                    <flux:menu.item icon="eye" kbd="⌘V" class="px-4 py-2 hover:bg-gray-100 transition-all">
                                        <a href="{{ route('resguardos.show', $resguardo->folio) }}"
                                            class="block text-gray-700">Ver</a>
                                    </flux:menu.item>
                                    <flux:menu.item icon="pencil-square" kbd="⌘E"
                                        class="px-4 py-2 hover:bg-gray-100 transition-all">
                                        <a href="{{ route('resguardos.edit', $resguardo->folio) }}"
                                            class="block text-gray-700">Editar</a>
                                    </flux:menu.item>
                                    <div class>
                                        <form action="{{ route('resguardos.cancel', $resguardo->folio) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas cancelar este resguardo?');">
                                            @csrf
                                            @method('PATCH') <!-- ✅ Correctly sends a PUT request -->
                                            <input type="hidden" name="estatus" value="Cancelado">
                                            <flux:menu.item type="submit" icon="x-circle" kbd="⌘⌫"
                                                class="px-4 py-2 hover:bg-red-100 transition-all" variant="danger">Cancelar
                                            </flux:menu.item>
                                        </form>
                                    </div>
                                </flux:menu>
                            </flux:dropdown>

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