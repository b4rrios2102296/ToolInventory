<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserActionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::connection('toolinventory')
            ->table('user_actions')
            ->leftJoin('usuarios', 'user_actions.user_id', '=', 'usuarios.id')
            ->select(
                'user_actions.id', // Agregar ID
                DB::raw("CONCAT(usuarios.nombre, ' ', usuarios.apellidos) AS usuario_nombre_completo"),
                'user_actions.accion',
                'user_actions.resguardo_id',
                'user_actions.comentarios',
                'user_actions.created_at'
            )
            ->orderBy('user_actions.created_at', 'desc')
            ->get()
            ->map(function ($accion) {
                return [
                    'id' => $accion->id, // Agregar ID
                    'usuario_nombre_completo' => $accion->usuario_nombre_completo,
                    'accion' => $accion->accion,
                    'folio' => $accion->resguardo_id,
                    'comentarios' => $accion->comentarios,
                    'fecha' => \Carbon\Carbon::parse($accion->created_at)->format('d/m/Y H:i'),
                ];
            });

    }

    public function headings(): array
    {
        return [
            'ID', // Agregar ID
            'Usuario',
            'Acción',
            'Folio',
            'Comentarios',
            'Fecha',
        ];
    }

}