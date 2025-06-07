<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // ¡Importante!
use App\Exports\UserActionsExport;

class UserActionsController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('user_audit')) {
            abort(403, 'No tienes permisos para ver esta sección.');
        }

        $search = $request->input('search');

        $acciones = DB::connection('toolinventory')
            ->table('user_actions')
            ->leftJoin('usuarios', 'user_actions.user_id', '=', 'usuarios.id')
            ->select('user_actions.*', 'usuarios.nombre', 'usuarios.apellidos')
            ->orderBy('user_actions.created_at', 'desc');

        // Aplicar filtro de búsqueda
        if ($search) {
            $acciones->where(function ($q) use ($search) {
                $q->where('user_actions.id', 'like', "%{$search}%") // Agregar búsqueda por ID
                    ->orWhere('user_actions.accion', 'like', "%{$search}%")
                    ->orWhere('user_actions.resguardo_id', 'like', "%{$search}%")
                    ->orWhere('user_actions.comentarios', 'like', "%{$search}%")
                    ->orWhere('user_actions.created_at', 'like', "%{$search}%")
                    ->orWhere('usuarios.nombre', 'like', "%{$search}%")
                    ->orWhere('usuarios.apellidos', 'like', "%{$search}%");
            });
        }


        $acciones = $acciones->paginate(10);

        return view('livewire.audit.user', compact('acciones'));
    }


    public function export()
    {
        return Excel::download(new UserActionsExport, 'acciones.xlsx');
    }

    public function exportPDF()
    {
        // Obtener los datos de user_actions
        $acciones = DB::connection('toolinventory')
            ->table('user_actions')
            ->leftJoin('usuarios', 'user_actions.user_id', '=', 'usuarios.id')
            ->select(
                'user_actions.id',
                DB::raw("CONCAT(usuarios.nombre, ' ', usuarios.apellidos) AS usuario_nombre_completo"),
                'user_actions.accion',
                'user_actions.resguardo_id',
                'user_actions.comentarios',
                'user_actions.created_at' // Ensure this is included
            )
            ->orderBy('user_actions.created_at', 'desc')
            ->get();
        foreach ($acciones as $accion) {
            if (!isset($accion->created_at)) {
                \Log::error("Missing created_at for action ID: " . $accion->id);
            } else {
                $accion->fecha_hora = \Carbon\Carbon::parse($accion->created_at)
                    ->setTimezone('America/Cancun')
                    ->format('d/m/Y h:i A');
            }
        }



        // Transformar los datos agregando la fecha formateada
        $acciones = $acciones->map(function ($accion) {
            return (object) [
                'id' => $accion->id,
                'usuario_nombre_completo' => $accion->usuario_nombre_completo,
                'accion' => $accion->accion,
                'resguardo_id' => $accion->resguardo_id,
                'comentarios' => $accion->comentarios,
                'fecha_hora' => \Carbon\Carbon::parse($accion->created_at)
                    ->setTimezone('America/Cancun')
                    ->format('d/m/Y h:i A')
            ];
        });

        // Generar el PDF con la vista correcta
        $pdf = Pdf::loadView('livewire.audit.listauser', compact('acciones'));

        // Descargar el PDF
        return $pdf->download('acciones.pdf');
    }


}
