@extends('layouts.app')
@fluxAppearance
@section('content')
    <div class="overflow-x-auto">
        <div class="container mx-auto px-4 py-8">
          <div>
    <h1 class="text-2xl font-bold mb-6 text-center">Últimos Resguardos</h1>

    @if(!Auth::user()->hasPermission('read_access')) 
        <flux:button icon="plus-circle" href="{{ route('resguardos.create') }}">
            Nuevo Resguardo
        </flux:button>
    @endif
</div>

            <br>
            <flux:separator />
            <flux:separator />
            <br>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="px-6 py-4 text-center">Folio</th>
                        <th class="px-6 py-4 text-center">Estatus</th>
                        <th class="px-6 py-4 text-center">Realizó Resguardo</th>
                        <th class="px-6 py-4 text-center">Asignado a</th>
                        <th class="px-6 py-4 text-center">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resguardos as $resguardo)
                        <tr class="border-b border-gray-300 last:border-0">
                            <td class="px-6 py-4 text-center align-middle">
                                <flux:link variant="subtle" href="{{ route('resguardos.show', $resguardo->folio) }}">
                                    {{ $resguardo->folio }}
                                </flux:link>
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if($resguardo->estatus == 'Resguardo')
                                    <flux:badge color="teal"  variant="solid" class="inline-block">
                                        {{ $resguardo->estatus }}
                                    </flux:badge>
                                @else
                                    {{ $resguardo->estatus }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                {{ $resguardo->aperturo_nombre }} {{ $resguardo->aperturo_apellidos }}
                            </td>

                            <td class="px-6 py-4 text-center align-middle">{{ $resguardo->colaborador_nombre }}</td>
                            <td class="px-6 py-4 text-center align-middle">
                                {{ \Carbon\Carbon::parse($resguardo->created_at)->setTimezone('America/Cancun')->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-center items-center">
                <flux:button class="justify-center" icon="eye" href="{{ route('resguardos.index') }}">
                    Ver todos los Resguardos
                </flux:button>
            </div>

        </div>
@endsection