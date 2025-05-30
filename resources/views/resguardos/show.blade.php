@extends('layouts.app')
<div class="flex justify-center">
    <flux:fieldset>
        <h1 class="text-2xl font-bold mb-6 text-center text-[#321F01]">Información de Resguardo</h1>

        <div class="space-y-6">
            <flux:input label="Folio" :value="$resguardo->folio" readonly class="max-w-sm" />
            <flux:input label="Estatus" :value="$resguardo->estatus" readonly class="max-w-sm" />
            <flux:input label="Realizó Resguardo" :value="($resguardo->aperturo_nombre ?? '') . ' ' . ($resguardo->aperturo_apellidos ?? '')" readonly class="max-w-sm" />
            <flux:input label="Asignado a" :value="$resguardo->asignado_nombre ?? 'No asignado'" readonly
                class="max-w-sm" />
            <flux:input label="Colaborador" :value="$resguardo->colaborador_num" readonly class="max-w-sm" />
            <flux:input label="Fecha de Resguardo"
                :value="\Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y')" readonly class="max-w-sm" />

            <div class="col-span-2">
                <h3 class="font-semibold text-lg mb-4 text-center">Detalle de Resguardo</h3>
                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-700 text-left">
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


            <br>
            <flux:button href="{{ route('resguardos.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md">
                Volver al Listado</flux:button>
    </flux:fieldset>
</div>