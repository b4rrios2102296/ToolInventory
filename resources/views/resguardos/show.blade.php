@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-4">
            <div class="ml-4 mt-2">
                <flux:button icon="arrow-left" href="{{ route('resguardos.index') }}">Volver</flux:button>
            </div>
            <h1 class="text-2xl font-bold flex-1 text-center">Información de Resguardo #{{ $resguardo->folio }}</h1>
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
                <!-- Card: Datos del Resguardo -->
                <div class="border rounded-lg shadow p-4 space-y-6">
                    <h2 class="text-lg font-semibold">Detalles del Resguardo</h2>
                    <flux:input label="Folio" :value="$resguardo->folio" readonly class="w-full" />
                    <flux:input label="Estatus" :value="$resguardo->estatus" readonly class="w-full" />
                    <flux:input label="Realizó Resguardo" :value="($resguardo->aperturo_nombre ?? '') . ' ' . ($resguardo->aperturo_apellidos ?? '')" readonly class="w-full" />
                    <flux:input label="Asignado a" :value="$resguardo->asignado_nombre ?? 'No asignado'" readonly
                        class="w-full" />
                    <flux:input label="Colaborador" :value="$resguardo->colaborador_num" readonly class="w-full" />
                    <flux:input label="Fecha de Resguardo"
                        :value="\Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y')" readonly
                        class="w-full" />
                </div>

                <!-- Card: Detalle del Resguardo -->
                <div class="border rounded-lg shadow p-4 space-y-4">
                    <h2 class="text-lg font-semibold">Detalle de Resguardo</h2>
                    <div class="p-3 rounded">
                        @php
                            $detalles = json_decode($resguardo->detalles_resguardo ?? '[]', true);
                        @endphp
                        @if(!empty($detalles))
                            <ul class="list-disc space-y-2">
                                @foreach($detalles as $detalle)
                                    <li>{{ is_string($detalle) ? $detalle : json_encode($detalle) }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No hay detalles disponibles.</p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="flex justify-end gap-4">
                <flux:button href="{{ route('resguardos.edit', $resguardo->folio) }}" icon="pencil-square"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Editar
                </flux:button>
                <flux:button href="{{ route('resguardo.pdf', ['folio' => $resguardo->folio]) }}" icon="document-arrow-down"
                    target="_blank">
                        Descargar PDF 📄
                    </flux:button>

                </div>
            </div>
        </div>
@endsection