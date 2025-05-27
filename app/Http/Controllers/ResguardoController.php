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

        $herramienta = DB::connection('toolinventory')
            ->table('herramientas')
            ->where('id', $request->herramienta_id)
            ->first();

        if (!$herramienta) {
            return redirect()->back()
                ->withErrors(['herramienta_id' => 'La herramienta seleccionada no existe'])
                ->withInput();
        }

        try {
            return DB::connection('toolinventory')->transaction(function () use ($request, $herramienta) {
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

                // Definir detalles_resguardo dentro del closure
                $detalles_resguardo = json_encode([
                    'id' => $herramienta->id,
                    'articulo' => $herramienta->articulo,
                    'modelo' => $herramienta->modelo,
                    'num_serie' => $herramienta->num_serie,
                    'cantidad' => $request->cantidad,
                ]);

                // Insertar resguardo
                DB::connection('toolinventory')->table('resguardos')->insert([
                    'folio' => $folio,
                    'estatus' => 'Activo',
                    'colaborador_num' => $colaborador->claveColab,
                    'aperturo_users_id' => $usuario->id,
                    'asigno_users_id' => $usuario->id,
                    'fecha_captura' => Carbon::parse($request->fecha_captura),
                    'prioridad' => $request->prioridad,
                    'observaciones' => $request->observaciones,
                    'detalles_resguardo' => $detalles_resguardo, // <-- aquí
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
        // Obtener los resguardos junto con los datos del usuario que aperturó el resguardo
        $resguardos = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.*',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos'

            )
            ->get();

        $colaborador_nums = $resguardos->pluck('colaborador_num')->unique()->filter();
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $colaborador_nums)
            ->pluck('nombreCompleto', 'claveColab');

        foreach ($resguardos as $resguardo) {
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? '';
        }

        // Pasar los datos al view
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
            ->select(
                '*'
            )
            ->selectRaw("
                LTRIM(RTRIM(RIGHT(Area, LEN(Area) - CHARINDEX('-', Area)))) AS area_limpia,
                LTRIM(RTRIM(RIGHT(Sucursal, LEN(Sucursal) - CHARINDEX('-', Sucursal)))) AS sucursal_limpia
            ")
            ->where(function ($query) use ($request) {
                $query->where('claveColab', 'like', '%' . $request->clave . '%')
                    ->orWhere('nombreCompleto', 'like', '%' . $request->clave . '%');
            })
            ->where('estado', '1')
            ->first();

        return response()->json($colaborador ?? ['error' => 'No se encontró el colaborador']);
    }
}