@extends('layouts.app')

@section('content')

    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-4">
            <div class="ml-4 mt-2">
                <flux:button icon="arrow-left" href="{{ url('/herramientas') }}">Volver</flux:button>
            </div>

            <h1 class="text-2xl font-bold flex-1 text-center">Detalles de Herramienta #{{ $herramienta->id }}</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Card: Datos de la Herramienta -->
                <div class="border rounded-lg shadow p-4 space-y-6">
                    <h2 class="text-lg font-semibold">Detalles de la Herramienta</h2>

                    <!-- Estatus Handling -->
                    <div>
                        @if($herramienta->estatus == 'Resguardo')
                            @php
                                $resguardo = DB::connection('toolinventory')
                                    ->table('resguardos')
                                    ->where('detalles_resguardo', 'like', '%"id":"' . $herramienta->id . '"%')
                                    ->where('estatus', 'Resguardo') // Ensure resguardo also has the correct status
                                    ->first();
                            @endphp
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Estatus</label>

                                <div class="mt-1">
                                    @if($herramienta->estatus == 'Resguardo')
                                        @php
                                            $resguardo = DB::connection('toolinventory')
                                                ->table('resguardos')
                                                ->where('detalles_resguardo', 'like', '%"id":"' . $herramienta->id . '"%')
                                                ->where('estatus', 'Resguardo') // Ensure resguardo also has the correct status
                                                ->first();
                                        @endphp
                                        <a href="{{ route('resguardos.show', $resguardo->folio) }}">
                                            <flux:badge color="teal" variant="solid">
                                                Resguardo
                                            </flux:badge>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @elseif ($herramienta->estatus == 'Baja')
                            <label class="block text-sm font-medium">Estatus</label>
                            <div class="mt-1">
                                <flux:badge color="red" variant="solid">

                                    {{ $herramienta->estatus }}
                                </flux:badge>
                            </div>
                        @else
                            <label class="block text-sm font-medium">Estatus</label>
                            <div class="mt-1">
                                <flux:badge color="green" variant="solid">
                                    {{ $herramienta->estatus }}
                                </flux:badge>
                            </div>
                        @endif
                    </div>


                    <flux:input label="Artículo" :value="$herramienta->articulo" readonly class="w-full" />
                    <flux:input label="Unidad" :value="$herramienta->unidad" readonly class="w-full" />
                    <flux:input label="Modelo" :value="$herramienta->modelo" readonly class="w-full" />
                    <flux:input label="Número de Serie" :value="$herramienta->num_serie" readonly class="w-full" />
                    <flux:input label="Costo" :value="number_format($herramienta->costo, 2)" readonly class="w-full" />
                </div>

                <!-- Card: Observaciones -->
                <div class="border rounded-lg shadow p-4 space-y-4">
                    <h2 class="text-lg font-semibold">Observaciones</h2>
                    <div>
                        {{ $herramienta->observaciones ?? 'No hay observaciones registradas.' }}
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                @if ($herramienta->estatus == 'Disponible' && !auth()->user()->hasPermission('read_access'))
                    <flux:button href="{{ route('herramientas.edit', $herramienta->id) }}" icon="pencil-square"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Editar
                    </flux:button>
                @endif
            </div>
        </div>
@endsection