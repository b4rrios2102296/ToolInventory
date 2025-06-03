<?php

namespace App\Exports;

use App\Models\Resguardo;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResguardosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Resguardo::all();
    }
}
