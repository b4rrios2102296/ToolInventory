<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resguardo Folio {{ $resguardo->folio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            padding: 15px;
            margin: 0 auto;
            max-width: 210mm;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 14px;
            margin: 3px 0;
            text-transform: uppercase;
        }

        .header h3 {
            font-size: 15px;
            font-weight: bold;
            border-bottom: 1px solid #2e2e2e;
            padding-bottom: 4px;
            margin: 8px 0 12px 0;
            text-transform: uppercase;
        }

        .info-section {
            margin-bottom: 8px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .date-container {
            text-align: left;
        }

        .folio-container {
            text-align: right;
            margin-top: -35px;
        }

        .two-columns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .column {
            width: 48%;
        }

        .bold {
            font-weight: bold;
        }

        .bold-folio {
            font-weight: bold;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .conditions {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #2e2e2e;
        }

        .tool-details {
            margin-left: 15px;
        }

        ul {
            padding-left: 20px;
            margin: 5px 0;
        }

        li {
            margin-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 1px solid #2e2e2e;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border: 1px solid #2e2e2e;
        }

        .signature-space {
            height: 80px;
            position: relative;
        }

        .signature-line {
            border-top: 1px solid #2e2e2e;
            width: 80%;
            position: absolute;
            bottom: 15px;
            left: 10%;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .compact {
            margin: 5px 0;
        }
        
        .colaborador-id {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('Images/grand-velas-riviera-maya-mexico-logo-_1_.png'))) }}"
            class="logo" alt="Grand Velas Logo">
    </div>

    <div class="header">
        <h3>RESGUARDO DE HERRAMIENTA</h3>
    </div>

    <div class="header-row">
        <div class="date-container">
            <p class="compact"><span class="bold">Fecha:</span> {{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y') }}</p>
        </div>
        <div class="folio-container">
            <p class="compact"><span class="bold-folio">Folio:</span> {{ $resguardo->folio }}</p>
        </div>
    </div>

    <div class="info-section">
        <p class="compact"><span class="bold">Nombre:</span> <span
                class="uppercase">{{ $colaborador->nombreCompleto ?? 'No disponible' }}</span></p>
        <p class="colaborador-id"><span class="bold"> Número de Colaborador:</span> {{ $colaborador->claveColab ?? 'N/A' }}</p>
        <p class="compact"><span class="bold">Puesto:</span> <span
                class="uppercase">{{ $colaborador->Puesto ?? 'No especificado' }}</span></p>
        <p class="compact"><span class="bold">Área:</span> <span
                class="uppercase">{{ $colaborador->area_limpia ?? 'No especificado' }}</span></p>
        <p class="compact"><span class="bold">Ambiente:</span> <span
                class="uppercase">{{ $colaborador->sucursal_limpia ?? 'No especificado' }}</span></p>
    </div>

    <p class="bold">Comentarios:</p>
    <p>{{ $resguardo->comentarios ?: 'Ninguno' }}</p>

    <div class="conditions">
        <p>El presente resguardo ampara la responsabilidad del colaborador para con la empresa
            <span class="bold uppercase">Grand Velas Riviera Maya</span>. Para el uso que para su fin existe y el
            cuidado la herramienta en su poder, mismo que se rige bajo las siguientes condiciones:
        </p>

        <p class="bold">CONDICIONES</p>
        <p>- La empresa otorga bajo custodia la siguiente herramienta, misma que se detalla a continuación:</p>

        @if($herramienta)
            <div class="tool-details">
                <ul>
                    <li><span class="bold">Artículo:</span> {{ $herramienta->articulo }}</li>
                    <li><span class="bold">Modelo/Serie:</span> {{ $herramienta->modelo }} / {{ $herramienta->num_serie }}
                    </li>
                    <li><span class="bold">Valor:</span>
                        {{ $herramienta->costo ? '$' . number_format($herramienta->costo, 2) : 'N/A' }}</li>
                </ul>
            </div>
        @else
            <p>No hay herramienta registrada</p>
        @endif
    </div>

    <div class="conditions">
        <p class="bold" style="text-align: center;">DECLARACIÓN DE RESPONSABILIDAD</p>
        <p>EL COLABORADOR DECLARA HABER RECIBIDO LA HERRAMIENTA AQUÍ MENCIONADA, SE COMPROMETE A CUIDARLA Y UTILIZARLA
            CORRECTAMENTE, TAMBIÉN A DEVOLVERLA CUANDO POR ALGÚN MOTIVO TENGA QUE DEJAR DE LABORAR, CON SU FIRMA SE
            RESPONSABILIZA POR ALGUNA HERRAMIENTA EXTRAVIADA</p>
    </div>

    <table>
        <tr>
            <td style="width:50%">
                <p class="bold">RECIBIDO POR</p>
                <p class="uppercase">{{ $colaborador->nombreCompleto ?? 'No disponible' }}</p>
                <div class="signature-space">
                    <div class="signature-line"></div>
                </div>
                <p>Firma</p>
            </td>
            <td style="width:50%">
                <p class="bold">ENTREGADO POR</p>
                <p class="uppercase">{{ $resguardo->aperturo_nombre ?? 'No disponible' }}
                    {{ $resguardo->aperturo_apellidos ?? '' }}
                </p>
                <div class="signature-space">
                    <div class="signature-line"></div>
                </div>
                <p>Firma</p>
            </td>
        </tr>
    </table>
</body>

</html>