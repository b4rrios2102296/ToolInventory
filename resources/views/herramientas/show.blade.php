@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route('herramientas.index') }}">Volver </flux:button>
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
            <div class="border rounded-lg shadow p-4 space-y-6" style="background-color: #FFF9F2; color: #321F01;">
                <h2 class="text-lg font-semibold">Detalles de la Herramienta</h2>
                <flux:input label="Estatus" :value="$herramienta->estatus" readonly class="w-full" />
                <flux:input label="Artículo" :value="$herramienta->articulo" readonly class="w-full" />
                <flux:input label="Unidad" :value="$herramienta->unidad" readonly class="w-full" />
                <flux:input label="Modelo" :value="$herramienta->modelo" readonly class="w-full" />
                <flux:input label="Número de Serie" :value="$herramienta->num_serie" readonly class="w-full" />
                <flux:input label="Costo" :value="number_format($herramienta->costo, 2)" readonly class="w-full" />
            </div>

            <!-- Card: Observaciones -->
            <div class="border rounded-lg shadow p-4 space-y-4" style="background-color: #FFF9F2; color: #321F01;">
                <h2 class="text-lg font-semibold">Observaciones</h2>
                <div class="bg-gray-100 p-3 rounded">
                    {{ $herramienta->observaciones ?? 'No hay observaciones registradas.' }}
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <flux:button href="{{ route('herramientas.edit', $herramienta->id) }}" icon="pencil-square"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Editar
            </flux:button>
        </div>
    </div>
</div>
@endsection
