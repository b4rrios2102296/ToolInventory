<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResguardoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'claveColab' => 'required|string',
            'GVRMT' => 'required|integer|exists:toolinventory.herramientas,GVRMT',
            'cantidad' => 'required|integer|min:1',
            'fecha_captura' => 'required|date',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'observaciones' => 'nullable|string|max:500',
        ]);

        return DB::connection('toolinventory')->transaction(function () use ($request) {
            // ✅ Validate collaborator in external `sqlsrv` connection
            $colaborador = DB::connection('sqlsrv')
                ->table('colaborador')
                ->where('claveColab', $request->claveColab)
                ->where('estado', '1')
                ->first();

            if (!$colaborador) {
                return back()->withErrors(['claveColab' => 'El colaborador no existe en la base de datos externa.']);
            }

            // ✅ Get authenticated user
            $usuario = DB::connection('toolinventory')
                ->table('usuarios')
                ->where('id', auth()->id())
                ->firstOrFail();

            // ✅ Generate a numeric folio
            $folio = $this->generarFolio();

            // ✅ Insert without enforcing FK constraints
            DB::connection('toolinventory')->table('resguardos')->insert([
                'folio' => $folio,
                'estatus' => 'Activo',
                'herramienta_id' => $request->GVRMT,
                'colaborador_num' => $colaborador->claveColab, // ✅ Now validated manually
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
        // ✅ Ensure we're using a numeric folio
        $ultimo = DB::connection('toolinventory')
            ->table('resguardos')
            ->orderBy('folio', 'desc') 
            ->first();

        // If no previous folio exists, start from 1
        $numero = $ultimo ? intval($ultimo->folio) + 1 : 1;

        return $numero; // ✅ Returns a numeric folio instead of a string like "RSG-000001"
    }
    public function index()
{
    $resguardos = DB::connection('toolinventory')
        ->table('resguardos')
        ->get(); // Retrieve all resguardos

    return view('resguardos', compact('resguardos'));
}

}
