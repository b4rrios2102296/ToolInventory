<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResguardoController extends Controller
{
    public function buscarColaborador(Request $request)
    {
        $request->validate(['clave' => 'required|string']);

        $colaborador = Colaborador::where('claveColab', $request->clave)
            ->where('estado', '1')
            ->firstOrFail();

        return response()->json([
            'claveColab' => $colaborador->claveColab,
            'nombreCompleto' => $colaborador->nombreCompleto,
            'Puesto' => $colaborador->Puesto,
            'area_limpia' => $colaborador->area_limpia,
            'sucursal_limpia' => $colaborador->sucursal_limpia
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'claveColab' => 'required|string',
            'herramienta_id' => 'required|integer|exists:toolinventory.herramientas,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_entrega' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_entrega',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'observaciones' => 'nullable|string|max:500',
        ]);

        return DB::connection('toolinventory')->transaction(function () use ($request) {
            // Verificar existencia del colaborador
            $colaborador = Colaborador::where('claveColab', $request->claveColab)
                ->where('estado', '1')
                ->firstOrFail();

            // Obtener usuario autenticado
            $usuario = DB::connection('toolinventory')
                ->table('usuarios')
                ->where('id', auth()->id())
                ->firstOrFail();

            // Generar folio único
            $folio = $this->generarFolio();

            // Crear resguardo
            DB::connection('toolinventory')->table('resguardos')->insert([
                'folio' => $folio,
                'estatus' => 'Activo',
                'herramienta_id' => $request->herramienta_id,
                'colaborador_num' => $colaborador->claveColab,
                'usuario_registro_id' => $usuario->id,
                'aperturo_users_id' => $usuario->id,
                'asigno_users_id' => $usuario->id,
                'cantidad' => $request->cantidad,
                'fecha_entrega' => Carbon::parse($request->fecha_entrega),
                'fecha_devolucion' => $request->fecha_devolucion 
                    ? Carbon::parse($request->fecha_devolucion) 
                    : null,
                'prioridad' => $request->prioridad,
                'observaciones' => $request->observaciones,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('resguardos.index')
                ->with('success', "Resguardo $folio creado exitosamente");
        });
    }

    protected function generarFolio()
    {
        $ultimo = DB::connection('toolinventory')
            ->table('resguardos')
            ->orderBy('id', 'desc')
            ->first();

        $numero = $ultimo ? intval(substr($ultimo->folio, 4)) + 1 : 1;

        return 'RSG-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
}