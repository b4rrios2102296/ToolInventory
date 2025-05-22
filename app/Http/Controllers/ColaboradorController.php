<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function buscarColaborador(Request $request)
    {
        $clave = $request->query('clave');

        $colaborador = DB::connection('sqlsrv')
            ->table('colaborador')
            ->select('claveColab', 'nombreCompleto', 'Puesto', 'Area', 'Sucursal')
            ->selectRaw("
                LTRIM(RTRIM(RIGHT(Area, LEN(Area) - CHARINDEX('-', Area)))) AS area_limpia,
                LTRIM(RTRIM(RIGHT(Sucursal, LEN(Sucursal) - CHARINDEX('-', Sucursal)))) AS sucursal_limpia
            ")
            ->where('claveColab', $clave)
            ->where('estado', '1')
            ->first();

        if (!$colaborador) {
            return response()->json(['error' => 'No se encontró ningún colaborador con ese número']);
        }

        return response()->json($colaborador);
    }

    public function index()
    {
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->select('claveColab', 'nombreCompleto', 'Puesto', 'Area', 'Sucursal')
            ->where('estado', '=', '1')
            ->orderBy('claveColab', 'asc')
            ->selectRaw("
                LTRIM(RTRIM(RIGHT(Area, LEN(Area) - CHARINDEX('-', Area)))) AS area_limpia,
                LTRIM(RTRIM(RIGHT(Sucursal, LEN(Sucursal) - CHARINDEX('-', Sucursal)))) AS sucursal_limpia
            ")
            ->get();

        // ✅ Fetch herramientas
        $herramientas = DB::connection('toolinventory')
            ->table('herramientas') 
            ->select('GVRMT', 'articulo', 'modelo')
            ->get();

        return view('colaboradores', compact('colaboradores', 'herramientas'));
    }
}
