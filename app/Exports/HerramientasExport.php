<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HerramientasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::connection('toolinventory')
            ->table('herramientas')
            ->select(
                'id',
                'estatus',
                'articulo',
                'unidad',
                'modelo',
                'num_serie',
                'costo',
                'observaciones' // Add Observaciones field
            )
            ->orderByRaw("CAST(SUBSTRING_INDEX(herramientas.id, '-', -1) AS UNSIGNED) DESC")
            ->get()
            ->map(function ($herramienta) {
                // If the status is "Baja", include specific observations
                $herramienta->observaciones = $herramienta->estatus === 'Baja'
                    ? "Dado de Baja: " . ($herramienta->observaciones ?? 'Sin observaciones')
                    : $herramienta->observaciones;

                return $herramienta;
            });
    }


    public function headings(): array
    {
        return [
            'ID',
            'Estatus',
            'Artículo',
            'Unidad',
            'Modelo',
            'Número de Serie',
            'Costo',
            'Observaciones' // New field added
        ];
    }

}
