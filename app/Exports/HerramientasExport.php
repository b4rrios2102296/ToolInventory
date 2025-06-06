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
                'costo'
            )
            ->orderByRaw("CAST(SUBSTRING_INDEX(herramientas.id, '-', -1) AS UNSIGNED) DESC")

            ->get();
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
            'Costo'
        ];
    }
}
