<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resguardo Folio {{ $resguardo->folio }}</title>
</head>
<body>
    <h1>Resguardo Folio #{{ $resguardo->folio }}</h1>
    <p><strong>Estatus:</strong> {{ $resguardo->estatus }}</p>
    <p><strong>Realizó Resguardo:</strong> {{ $resguardo->aperturo_nombre }} {{ $resguardo->aperturo_apellidos }}</p>
    <p><strong>Asignado a:</strong> {{ $resguardo->asignado_nombre }}</p>
    <p><strong>Colaborador:</strong> {{ $resguardo->colaborador_num }}</p>
    <p><strong>Fecha de Resguardo:</strong> {{ $resguardo->fecha_captura }}</p>

    @php
        $detalles = json_decode($resguardo->detalles_resguardo, true) ?? [];
        $herramienta = DB::connection('toolinventory')
            ->table('herramientas')
            ->where('id', $detalles['id'] ?? null)
            ->first();
    @endphp

    <p><strong>Detalle del Resguardo:</strong></p>
    @if ($herramienta)
        <ul>
            <li><strong>ID:</strong> {{ $herramienta->id }}</li>
            <li><strong>Nombre:</strong> {{ $herramienta->articulo }}</li>
            <li><strong>Modelo:</strong> {{ $herramienta->modelo }}</li>
            <li><strong>Número de Serie:</strong> {{ $herramienta->num_serie }}</li>
            <li><strong>Costo:</strong> {{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}</li>
        </ul>
    @else
        <p>No hay detalles disponibles para esta herramienta.</p>
    @endif
</body>
</html>
