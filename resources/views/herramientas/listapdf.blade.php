<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Herramientas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 7;
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
    <h1>Listado de Herramientas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estatus</th>
                <th>Artículo</th>
                <th>Detalle de Herramienta</th> <!-- Consolidated details -->
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($herramientas as $herramienta)
                <tr>
                    <td>{{ $herramienta->id }}</td>
                    <td>{{ $herramienta->estatus }}</td>
                    <td>{{ $herramienta->articulo }}</td>
                    <td>
                        <strong>Unidad:</strong> {{ $herramienta->unidad ?? 'N/A' }} <br>
                        <strong>Modelo:</strong> {{ $herramienta->modelo ?? 'N/A' }} <br>
                        <strong>Número de Serie:</strong> {{ $herramienta->num_serie ?? 'N/A' }}
                    </td>
                    <td>${{ number_format($herramienta->costo, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>