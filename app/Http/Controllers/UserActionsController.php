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
                'user_actions.id', // Agregar el ID aquí
                DB::raw("CONCAT(usuarios.nombre, ' ', usuarios.apellidos) AS usuario_nombre_completo"),
                'user_actions.accion',
                'user_actions.resguardo_id',
                'user_actions.comentarios',
                'user_actions.created_at'
            )
            ->orderBy('user_actions.created_at', 'desc')
            ->get();


        // Generar el PDF con la vista correcta
        $pdf = Pdf::loadView('livewire.audit.listauser', compact('acciones'));

        // Descargar el PDF
        return $pdf->download('acciones.pdf');
    }

}
