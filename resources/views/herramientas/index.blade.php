@extends('layouts.app')
@fluxAppearance

@section('content')
    <div class="overflow-x-auto">
        <div class="container mx-auto px-4 py-8">
            <div>
                <h1 class="text-2xl font-bold mb-6 text-center">Listado de Herramientas</h1>
                <flux:button icon="plus-circle" href="{{ route('herramientas.create') }}">Nueva Herramienta</flux:button>
            </div>
            <br>
            <flux:separator />
            <flux:separator />
            <br>
            <div>
                <flux:tooltip content="PDF">
                    <flux:button icon="document-arrow-down" icon:variant="outline" href="{{ route('herramientas.pdf') }}" />
                </flux:tooltip>
                <flux:tooltip content="Excel">
                    <flux:button icon="document-chart-bar" icon:variant="outline"
                        href="{{ route('herramientas.excel') }}" />
                </flux:tooltip>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Estatus</th>
                        <th class="px-4 py-2">Artículo</th>
                        <th class="px-4 py-2">Unidad</th>
                        <th class="px-4 py-2">Modelo</th>
                        <th class="px-4 py-2">Número de Serie</th>
                        <th class="px-4 py-2">Costo</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($herramientas as $herramienta)
                        <tr class="border-t text-center {{ $herramienta->estatus == 'Baja' ? ' text-gray-500' : '' }}">

                            <td class="px-4 py-2 whitespace-normal break-all max-w-xs text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->id }}</s>
                                @else
                                    {{ $herramienta->id }}
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($herramienta->estatus == 'Resguardo')
                                    @php
                                        $resguardo = DB::connection('toolinventory')
                                            ->table('resguardos')
                                            ->where('detalles_resguardo', 'like', '%"id":"'.$herramienta->id.'"%')
                                            ->first();
                                    @endphp
                                    @if($resguardo)
                                        <a href="{{ route('resguardos.show', $resguardo->folio) }}">
                                            <flux:badge color="teal">
                                                Resguardo
                                            </flux:badge>
                                        </a>
                                    @else
                                        <flux:badge color="teal">
                                            Resguardo
                                        </flux:badge>
                                    @endif
                                @else
                                    <flux:badge color="{{ $herramienta->estatus == 'Baja' ? 'zinc' : 'green' }}">
                                        @if($herramienta->estatus == 'Baja')
                                            <s>{{ $herramienta->estatus }}</s>
                                        @else
                                            {{ $herramienta->estatus }}
                                        @endif
                                    </flux:badge>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->articulo }}</s>
                                @else
                                    {{ $herramienta->articulo }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->unidad }}</s>
                                @else
                                    {{ $herramienta->unidad }}
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-normal break-all max-w-xs text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->modelo }}</s>
                                @else
                                    {{ $herramienta->modelo }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->num_serie }}</s>
                                @else
                                    {{ $herramienta->num_serie }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center align-middle">
                                @if ($herramienta->estatus == 'Baja')
                                    <s>{{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}</s>
                                @else
                                    {{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}
                                @endif
                            </td>
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

                                        @if ($herramienta->estatus != 'Baja')
                                            <form action="{{ route('herramientas.baja', $herramienta->id) }}" method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas dar de baja esta herramienta?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estatus" value="Baja">
                                                <flux:menu.item type="submit" icon="x-circle" variant="danger" kbd="⌘⌫">
                                                    Dar de Baja
                                                </flux:menu.item>
                                            </form>
                                        @endif
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
@endsection