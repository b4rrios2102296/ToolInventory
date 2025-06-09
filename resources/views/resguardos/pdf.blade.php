<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resguardo Folio {{ $resguardo->folio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
            font-size: 7;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h1 {
            font-size: 14px;
            /* Smaller title */
            font-weight: bold;
            margin: 0;
        }

        .header h2 {
            font-size: 12px;
            /* Smaller subtitle */
            margin: 3px 0 0 0;
        }

        .header h3 {
            font-size: 10px;
            /* Smaller section title */
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin: 3px 0 10px 0;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .two-columns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .column {
            width: 48%;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature-box {
            width: 45%;
            border-top: 1px solid #000;
            padding-top: 5px;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .conditions {
            margin: 15px 0;
        }

        .tool-details {
            margin-left: 20px;
        }

        ul {
            padding-left: 20px;
            margin: 5px 0;
        }

        li {
            margin-bottom: 3px;
        }

        .signature-img {
            height: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('Images/grand-velas-riviera-maya-mexico-logo-_1_.png'))) }}"
    style="width: 35%; margin-right: 55%; margin-bottom: 50px;">

<body>
    <div class="header">
        <h1>Grand Velas Riviera Maya</h1>
        <h2>TECNOLOGIAS DE LA INFORMACION</h2>
        <h3>RESGUARDO DE HERRAMIENTA</h3>
    </div>

    <div class="two-columns">
        <div class="column">
            <p><span class="bold">Fecha:</span> <span
                    class="uppercase">{{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}</span></p>
            <p><span class="bold">Folio de resguardo:</span> <span class="uppercase">{{ $resguardo->folio }}</span></p>
        </div>
        <div class="column"></div>
    </div>

    <div class="info-section">
        <p><span class="bold">NOMBRE COMPLETO:</span> <span
                class="uppercase">{{ $colaborador->nombreCompleto ?? 'No disponible' }}</span></p>
    </div>

    <div class="info-section">
        <p><span class="bold">N. COLABORADOR:</span> <span
                class="uppercase">{{ $colaborador->claveColab ?? 'No disponible' }}</span></p>
    </div>

    <div class="info-section">
        <p><span class="bold">PUESTO:</span> <span
                class="uppercase">{{ $colaborador->Puesto ?? 'No especificado' }}</span></p>
    </div>

    <div class="info-section">
        <p><span class="bold">AMBIENTE:</span> <span
                class="uppercase">{{ $colaborador->sucursal_limpia ?? 'No especificado' }}</span></p>
    </div>

    <div class="info-section">
        <p><span class="bold">DEPARTAMENTO:</span> <span
                class="uppercase">{{ $colaborador->area_limpia ?? 'No especificado' }}</span></p>
    </div>
    <p class="bold">Comentarios</p>
    <p>
        {{ $resguardo->comentarios }}
    </p>

    <div class="conditions">
        <p>El presente resguardo ampara la responsabilidad del colaborador para con la empresa
            <span class="bold uppercase">Grand Velas Riviera Maya</span>. Para el uso que para su fin existe y el
            cuidado la herramienta en su poder, mismo que se rige bajo las siguientes condiciones:
        </p>

        <p class="bold">CONDICIONES</p>
        <p>- La empresa otorga bajo custodia la siguiente herramienta, misma que se detalla a continuación:</p>

        @if($herramienta)
            <div class="tool-details">
                <ul style="list-style-type: disc; padding-left: 20px;">
                    <li><span class="bold">ID:</span> <span class="uppercase">{{ $herramienta->id }}</span></li>
                    <li><span class="bold">NOMBRE DEL ARTÍCULO:</span> <span
                            class="uppercase">{{ $herramienta->articulo }}</span></li>
                    <li><span class="bold">NUM SERIE:</span> <span class="uppercase">{{ $herramienta->num_serie }}</span>
                    </li>
                    <li><span class="bold">MODELO:</span> <span class="uppercase">{{ $herramienta->modelo }}</span></li>
                    <li><span class="bold">COSTO:</span> <span class="uppercase">
                            {{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}
                        </span></li>
                </ul>
            </div>
        @else
            <p>No hay herramienta registrada</p>
        @endif

        <p class="bold">COSTO TOTAL DE RESGUARDO:</p>
        <p class="uppercase">{{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}</p>
    </div>
    <div class="conditions">
        <p class="bold uppercase" style="text-align: center; ">EL COLABORADOR DECLARA HABER RECIBIDO LA HERRAMIENTA AQUÍ
            MENCIONADA, SE COMPROMETE A
            CUIDARLA Y
            UTILIZARLA CORRECTAMENTE, TAMBIÉN A DEVOLVERLA CUANDO POR ALGÚN MOTIVO TENGA QUE DEJAR DE LABORAR, CON SU
            FIRMA SE RESPONSABILIZA POR ALGUNA HERRAMIENTA EXTRAVIADA</p>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #000;">
        <tr>
            <!-- Columna de "Recibido Por" -->
            <th style="width: 50%; text-align: center; border: 1px solid #000; padding: 10px;">
                <p class="bold uppercase" style="font-size: 12px; margin-bottom: 5px;">RECIBIDO POR</p>
                <p class="uppercase" style="font-size: 10px; margin-bottom: 5px;">
                    {{ $colaborador->nombreCompleto ?? 'No disponible' }}
                </p>
                @if(!empty($resguardo->firma_recibido))
                    <img src="data:image/png;base64,{{ $resguardo->firma_recibido }}" class="signature-img"
                        alt="Firma Recibido" style="height: 80px; display: block; margin: 10px auto;">
                @else
                    <div style="height: 80px; margin-bottom: 10px; border-bottom: 1px dashed #ccc;"></div>
                @endif
                <hr style="width: 80%; margin: 5px auto; border: 0.5px solid #000;">
                <p style="font-size: 10px;">FIRMA</p>
            </th>

            <!-- Columna de "Entregado Por" -->
            <th style="width: 50%; text-align: center; border: 1px solid #000; padding: 10px;">
                <p class="bold uppercase" style="font-size: 12px; margin-bottom: 5px;">ENTREGADO POR</p>
                <p class="uppercase" style="font-size: 10px; margin-bottom: 5px;">
                    {{ $resguardo->aperturo_nombre ?? 'No disponible' }} {{ $resguardo->aperturo_apellidos ?? '' }}
                </p>
                @if(!empty($resguardo->firma_entregado))
                    <img src="data:image/png;base64,{{ $resguardo->firma_entregado }}" class="signature-img"
                        alt="Firma Entregado" style="height: 80px; display: block; margin: 10px auto;">
                @else
                    <div style="height: 80px; margin-bottom: 10px; border-bottom: 1px dashed #ccc;"></div>
                @endif
                <hr style="width: 80%; margin: 5px auto; border: 0.5px solid #000;">
                <p style="font-size: 10px;">FIRMA</p>
            </th>
        </tr>
    </table>

</body>

</html>