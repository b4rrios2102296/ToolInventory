<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserActionsController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('user_audit')) {
            abort(403, 'No tienes permisos para ver esta sección.');
        }

        $acciones = DB::connection('toolinventory')
            ->table('user_actions')
            ->leftJoin('usuarios', 'user_actions.user_id', '=', 'usuarios.id')
            ->select('user_actions.*', 'usuarios.nombre', 'usuarios.apellidos')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.audit.user', compact('acciones'));
    }

}
