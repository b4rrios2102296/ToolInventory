<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Resguardos</title>
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
    <h1>Listado de Resguardos</h1>
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Estado</th>
                <th>Realizó Resguardo</th>
                <th>Asignado a</th>
                <th>Fecha de Resguardo</th>
                <th>Detalle de Resguardo</th> <!-- Nuevo campo -->
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
                    <td>{!! $resguardo->detalle_resguardo !!}</td>
                    <td>{{ $resguardo->comentarios }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>