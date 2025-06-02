<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resguardo Folio {{ $resguardo->folio }}</title>
</head>
<body>
    <h1>Resguardo Folio #{{ $resguardo->folio }}</h1>
    <p><strong>Realizó Resguardo:</strong> {{ $resguardo->aperturo_nombre }} {{ $resguardo->aperturo_apellidos }}</p>
    <p><strong>Asignado a:</strong> {{ $colaborador->nombreCompleto ?? 'No asignado' }}</p>
    <p><strong>Colaborador:</strong> {{ $colaborador->claveColab ?? 'No disponible' }}</p>
    <p><strong>Fecha de Resguardo:</strong> {{ $resguardo->fecha_captura }}</p>

    <h2>Datos del Colaborador</h2>
    <ul>
        <li><strong>Número de Colaborador:</strong> {{ $colaborador->claveColab ?? 'No disponible' }}</li>
        <li><strong>Nombre Completo:</strong> {{ $colaborador->nombreCompleto ?? 'No disponible' }}</li>
        <li><strong>Puesto:</strong> {{ $colaborador->Puesto ?? 'No especificado' }}</li>
        <li><strong>Departamento:</strong> {{ $colaborador->area_limpia ?? 'No especificado' }}</li>
        <li><strong>Ambiente:</strong> {{ $colaborador->sucursal_limpia ?? 'No especificado' }}</li>
    </ul>

    <h2>Detalle del Resguardo</h2>
    @if ($herramienta)
        <ul>
            <li><strong>ID:</strong> {{ $herramienta->id }}</li>
            <li><strong>Unidad:</strong> {{ $herramienta->unidad }}
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
