<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Información de Resguardo</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <strong>Folio:</strong> {{ $resguardo->folio }}
        </div>
        <div class="mb-4">
            <strong>Estatus:</strong> {{ $resguardo->estatus }}
        </div>
        <div class="mb-4">
            <strong>Realizó Resguardo:</strong> {{ $resguardo->aperturo_nombre ?? '' }}
            {{ $resguardo->aperturo_apellidos ?? '' }}
        </div>
        <div class="mb-4">
            <strong>Asignado a:</strong> {{ $resguardo->asignado_nombre ?? 'No asignado' }}
        </div>

        <div class="mb-4">
            <strong>Colaborador:</strong> {{ $resguardo->colaborador_num }}
        </div>
        <div class="mb-4">
            <strong>Fecha de Resguardo:</strong> {{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}
        </div>
        <div class="mb-4">
            <strong>Detalle de Resguardo:</strong>
            @php
                $detalles = json_decode($resguardo->detalles_resguardo ?? '[]', true);
            @endphp
            @if(!empty($detalles))
                <ul class="space-y-2 text-center">
                    @foreach($detalles as $detalle)
                        <li>{{ is_string($detalle) ? $detalle : json_encode($detalle) }}</li>
                    @endforeach
                </ul>
            @else
                No hay detalles disponibles.
            @endif
        </div>
    </div>
    <br>
    <a href="{{ route('resguardos.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md">Volver al Listado</a>
</div>