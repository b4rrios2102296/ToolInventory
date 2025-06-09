<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $resguardos = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.folio',
                'resguardos.estatus',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos',
                'resguardos.colaborador_num',
                'resguardos.created_at'
            )
            ->where('resguardos.estatus', 'resguardo')
            ->orderBy('resguardos.folio', 'desc')
            ->paginate(10);


        // Obtener nombres de colaboradores
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $resguardos->pluck('colaborador_num')->unique())
            ->pluck('nombreCompleto', 'claveColab');

        // Asignar nombres de colaboradores
        $resguardos->transform(function ($resguardo) use ($colaboradores) {
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? 'Desconocido';
            return $resguardo;
        });

        return view('dashboard', compact('resguardos'));
    }
}


