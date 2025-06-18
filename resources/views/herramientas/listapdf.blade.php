<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Herramientas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
            color: #000;
            text-align: center;
        }

        h1 {
            font-size: 14px;
            margin: 5px 0;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 200px;
            height: auto;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
        }

        td {
            text-align: center;
            border-bottom: 1px solid #000;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 4px;
        }

        .detalle-herramienta {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('Images/grand-velas-riviera-maya-mexico-logo-_1_.png'))) }}"
            class="logo" alt="Grand Velas Logo">
    </div>
    <h1>Listado de Herramientas</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estatus</th>
                <th>Artículo</th>
                <th>Detalle de Herramienta</th>
                <th>Costo</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($herramientas as $herramienta)
                <tr>
                    <td>{{ $herramienta->id }}</td>
                    <td>{{ $herramienta->estatus }}</td>
                    <td>{{ $herramienta->articulo }}</td>
                    <td class="detalle-herramienta">
                        <strong>Unidad:</strong> {{ $herramienta->unidad ?? 'N/A' }}<br>
                        <strong>Modelo:</strong> {{ $herramienta->modelo ?? 'N/A' }}<br>
                        <strong>Número de Serie:</strong> {{ $herramienta->num_serie ?? 'N/A' }}
                    </td>
                    <td>{{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) . ' MXN' : 'N/A' }}</td>
                    <td>{{ $herramienta->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>