<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResguardoController extends Controller
{
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'herramienta_id' => 'required|integer',
            'colaborador_num' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            'fecha_entrega' => 'required|date',
            'prioridad' => 'required|in:Alta,Media,Baja',
        ]);

        try {
            // Obtener datos del colaborador de la primera base de datos
            $colaborador = DB::connection('sqlsrv')
                ->table('colaborador')
                ->where('claveColab', $request->colaborador_num)
                ->where('estado', '1')
                ->first();

            if (!$colaborador) {
                return back()->withInput()->with('error', 'Colaborador no encontrado o inactivo');
            }

            // Obtener usuario_id de la segunda base de datos
            $usuario = DB::connection('toolinventory')
                ->table('usuarios')
                ->where('identificador', auth()->user()->email) // Asumiendo autenticación
                ->first();

            if (!$usuario) {
                return back()->withInput()->with('error', 'Usuario no registrado en el sistema de autenticación');
            }

            // Generar folio consecutivo
            $ultimoFolio = DB::connection('toolinventory')
                ->table('resguardos')
                ->max('folio');

            $nuevoFolio = 'RSG-' . str_pad((intval(str_replace('RSG-', '', $ultimoFolio))) + 1, 6, '0', STR_PAD_LEFT);

            // Insertar el resguardo
            DB::connection('sqlsrv')->table('resguardos')->insert([
                'folio' => $nuevoFolio,
                'estatus' => 'Activo',
                'herramienta_id' => $request->herramienta_id,
                'colaborador_num' => $request->colaborador_num,
                'usuario_registro_id' => $usuario->id,
                'cantidad' => $request->cantidad,
                'fecha_entrega' => Carbon::parse($request->fecha_entrega),
                'fecha_devolucion' => $request->fecha_devolucion ? Carbon::parse($request->fecha_devolucion) : null,
                'prioridad' => $request->prioridad,
                'observaciones' => $request->observaciones,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('resguardos.index')
                ->with('success', 'Resguardo '.$nuevoFolio.' creado exitosamente');
            
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al registrar el resguardo: '.$e->getMessage());
        }
    }
}