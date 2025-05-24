<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ResguardoController extends Controller
{
    public function store(Request $request)
    {
        Log::debug('Resguardo store method called', $request->all());
        
        $validated = $request->validate([
            'claveColab' => 'required|string',
            'herramienta_id' => 'required|string|exists:toolinventory.herramientas,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_captura' => 'required|date',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'observaciones' => 'nullable|string|max:500',
        ]);

        try {
            return DB::connection('toolinventory')->transaction(function () use ($request) {
                // Validar colaborador
                $colaborador = DB::connection('sqlsrv')
                    ->table('colaborador')
                    ->where('claveColab', $request->claveColab)
                    ->where('estado', '1')
                    ->first();

                if (!$colaborador) {
                    return redirect()->back()
                        ->withErrors(['claveColab' => 'El colaborador no existe en la base de datos externa.'])
                        ->withInput();
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

                return redirect()->route('resguardos.index')
                    ->with('success', "Resguardo $folio creado exitosamente");
            });
        } catch (\Exception $e) {
            Log::error('Error creating resguardo: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear el resguardo')
                ->withInput();
        }
    }

    protected function generarFolio()
    {
        $ultimo = DB::connection('toolinventory')
            ->table('resguardos')
            ->orderBy('folio', 'desc')
            ->first();

        return $ultimo ? intval($ultimo->folio) + 1 : 1;
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
        $herramientas = DB::connection('toolinventory')
            ->table('herramientas')
            ->get();

        return view('resguardos.create', compact('herramientas'));
    }

    public function buscarColaborador(Request $request)
    {
        $colaborador = DB::connection('sqlsrv')
            ->table('colaborador')
            ->where('claveColab', 'like', '%'.$request->clave.'%')
            ->orWhere('nombreCompleto', 'like', '%'.$request->clave.'%')
            ->where('estado', '1')
            ->first();

        return response()->json($colaborador ?? ['error' => 'No se encontró el colaborador']);
    }
}