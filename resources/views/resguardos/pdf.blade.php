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
    <p><strong>Detalle:</strong> {{ $herramienta->nombre ?? 'No disponible' }}</p>
</body>
</html>
