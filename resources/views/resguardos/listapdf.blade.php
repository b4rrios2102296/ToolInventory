<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Resguardos de Herramientas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
            color: #000;
            text-align: center;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 200px;
            height: auto;
        }

        h1 {
            font-size: 14px;
            margin: 5px 0;
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
        }

        .detalle-resguardo {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('Images/grand-velas-riviera-maya-mexico-logo-_1_.png'))) }}"
            class="logo" alt="Grand Velas Logo">
    </div>

    <h1>Listado de Resguardos de Herramientas</h1>
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Estado</th>
                <th>Realizó Resguardo</th>
                <th>Asignado a</th>
                <th>Fecha de Resguardo</th>
                <th>Detalle de Resguardo</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resguardos as $resguardo)
                <tr>
                    <td>{{ $resguardo->folio }}</td>
                    <td>{{ $resguardo->estatus }}</td>
                    <td>{{ $resguardo->aperturo_nombre }} {{ $resguardo->aperturo_apellidos }}</td>
                    <td>{{ $resguardo->colaborador_nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}</td>
                    <td class="detalle-resguardo">{!! $resguardo->detalle_resguardo !!}</td>
                    <td>{{ $resguardo->comentarios }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
