<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResguardosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Fetch all resguardos from toolinventory
        $resguardos = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.folio',
                'resguardos.estatus',
                DB::raw("CONCAT(aperturo.nombre, ' ', aperturo.apellidos) AS aperturo_nombre_completo"),
                'resguardos.colaborador_num',
                'resguardos.fecha_captura',
                'resguardos.comentarios',
                'resguardos.detalles_resguardo'
            )
            ->orderBy('folio','desc')
            ->get();

        // Fetch collaborator details
        $colaborador_nums = $resguardos->pluck('colaborador_num')->filter()->unique();
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $colaborador_nums)
            ->pluck('nombreCompleto', 'claveColab');

        foreach ($resguardos as $resguardo) {
            // Ensure `detalles_resguardo` exists before decoding
            $detalles = isset($resguardo->detalles_resguardo) ? json_decode($resguardo->detalles_resguardo, true) : [];

            $herramienta = DB::connection('toolinventory')
                ->table('herramientas')
                ->where('id', $detalles['id'] ?? null)
                ->first();

            // Assign details in the correct order
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? 'No disponible';
            $resguardo->herramienta_articulo = $herramienta->articulo ?? 'N/A';
            $resguardo->herramienta_modelo = $herramienta->modelo ?? 'N/A';
            $resguardo->herramienta_num_serie = $herramienta->num_serie ?? 'N/A';
            $resguardo->herramienta_costo = $herramienta->costo ?? 0;

            // Format date correctly
            $resguardo->fecha_captura = \Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y');
        }

        // Ensure the output order matches the headings
        return $resguardos->map(function ($resguardo) {
            return [
                'folio' => $resguardo->folio,
                'estatus' => $resguardo->estatus,
                'aperturo_nombre_completo' => $resguardo->aperturo_nombre_completo,
                'colaborador_nombre' => $resguardo->colaborador_nombre,
                'colaborador_num' => $resguardo->colaborador_num,
                'fecha_captura' => $resguardo->fecha_captura,
                'herramienta_articulo' => $resguardo->herramienta_articulo,
                'herramienta_modelo' => $resguardo->herramienta_modelo,
                'herramienta_num_serie' => $resguardo->herramienta_num_serie,
                'herramienta_costo' => $resguardo->herramienta_costo,
                'comentarios' => $resguardo->comentarios,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Estado',
            'Realizó Resguardo',
            'Asignado a',
            'Num Colaborador',
            'Fecha de Resguardo',
            'Artículo',
            'Modelo',
            'Número de Serie',
            'Costo',
            'Comentarios'
        ];
    }
}



