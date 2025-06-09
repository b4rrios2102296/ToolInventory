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
            ->orderBy('folio', 'desc')
            ->get();

        // Fetch collaborator details
        $colaborador_nums = $resguardos->pluck('colaborador_num')->filter()->unique();
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $colaborador_nums)
            ->pluck('nombreCompleto', 'claveColab');

        foreach ($resguardos as $resguardo) {
            $detalles = isset($resguardo->detalles_resguardo) ? json_decode($resguardo->detalles_resguardo, true) : [];

            $herramienta = DB::connection('toolinventory')
                ->table('herramientas')
                ->where('id', $detalles['id'] ?? null)
                ->first();

            // Ensure collaborator details exist
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? 'No disponible';

            // Assign details in an escalera format
            $resguardo->detalle_resguardo =
                "ID: " . ($herramienta->id ?? 'N/A') . "\n" .
                "Artículo: " . ($herramienta->articulo ?? 'N/A') . "\n" .
                "Modelo: " . ($herramienta->modelo ?? 'N/A') . "\n" .
                "Número de Serie: " . ($herramienta->num_serie ?? 'N/A') . "\n" .
                "Costo: $" . number_format($herramienta->costo ?? 0, 2);
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
                'detalle_resguardo' => $resguardo->detalle_resguardo, // Consolidated details
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
            'Detalle de Resguardo', // Consolidated field
            'Comentarios'
        ];
    }

}



