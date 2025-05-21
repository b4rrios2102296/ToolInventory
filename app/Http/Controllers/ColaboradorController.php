<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function index()
    {
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->select('claveColab', 'nombreCompleto', 'Puesto', 'Area', 'Sucursal')
            ->orderBy('claveColab', 'asc') 
            ->where('estado', '=', '1')
            ->selectRaw("
                LTRIM(RTRIM(RIGHT(Area, LEN(Area) - CHARINDEX('-', Area)))) AS area_limpia,
                LTRIM(RTRIM(RIGHT(Sucursal, LEN(Sucursal) - CHARINDEX('-', Sucursal)))) AS sucursal_limpia
            ")
            ->get();

        return view('colaboradores', compact('colaboradores'));
    }
}
