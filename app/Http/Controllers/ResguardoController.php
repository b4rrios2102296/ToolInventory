<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResguardoController extends Controller
{
    public function store(Request $request)
    {
        // Cambia 'id' por 'herramienta_id' en todo el flujo para mayor claridad y consistencia
        $request->validate([
            'claveColab' => 'required|string',
            'herramienta_id' => 'required|integer|exists:toolinventory.herramientas,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_captura' => 'required|date',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'observaciones' => 'nullable|string|max:500',
        ]);

        return DB::connection('toolinventory')->transaction(function () use ($request) {
            // Validar colaborador en la base externa
            $colaborador = DB::connection('sqlsrv')
                ->table('colaborador')
                ->where('claveColab', $request->claveColab)
                ->where('estado', '1')
                ->first();

            if (!$colaborador) {
                return back()->withErrors(['claveColab' => 'El colaborador no existe en la base de datos externa.'])->withInput();
            }

            // Obtener usuario autenticado
            $usuario = DB::connection('toolinventory')
                ->table('usuarios')
                ->where('id', auth()->id())
                ->firstOrFail();

            // Generar folio
            $folio = $this->generarFolio();

            // Insertar resguardo
            DB::connection('toolinventory')->table('resguardos')->insert([
                'folio' => $folio,
                'estatus' => 'Activo',
                'herramienta_id' => $request->herramienta_id,
                'colaborador_num' => $colaborador->claveColab,
                'usuario_registro_id' => $usuario->id,
                'aperturo_users_id' => $usuario->id,
                'asigno_users_id' => $usuario->id,
                'cantidad' => $request->cantidad,
                'fecha_captura' => Carbon::parse($request->fecha_captura),
                'prioridad' => $request->prioridad,
                'observaciones' => $request->observaciones,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('resguardos')->with('success', "Resguardo $folio creado exitosamente");
        });
    }

    protected function generarFolio()
    {
        $ultimo = DB::connection('toolinventory')
            ->table('resguardos')
            ->orderBy('folio', 'desc')
            ->first();

        $numero = $ultimo ? intval($ultimo->folio) + 1 : 1;
        return $numero;
    }

    public function index()
    {
        $resguardos = DB::connection('toolinventory')
            ->table('resguardos')
            ->get();

        return view('resguardos.index', compact('resguardos'));
    }

    public function create()
    {
        $herramientas = \DB::connection('toolinventory')->table('herramientas')->get();
        return view('resguardos.create', compact('herramientas'));
    }
}