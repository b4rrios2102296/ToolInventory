<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Acciones de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Historial de Acciones de Usuarios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th> <!-- Nueva columna para el ID -->
                <th>Usuario</th>
                <th>Acción</th>
                <th>Folio</th>
                <th>Comentarios</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($acciones as $accion)
                <tr>
                    <td>{{ $accion->id }}</td>
                    <td>{{ $accion->usuario_nombre_completo }}</td>
                    <td>{{ $accion->accion ?? 'N/A' }}</td>
                    <td>{{ $accion->resguardo_id }}</td>
                    <td>{{ trim($accion->comentarios) !== '' ? $accion->comentarios : 'N/A' }}</td>
                    <td>{{ $accion->fecha_hora ?? 'Fecha no disponible' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>