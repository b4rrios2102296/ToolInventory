<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserEditorController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('user_audit')) {
            abort(403, 'No tienes permisos para ver esta sección.');
        }

        $search = $request->input('search');

        $query = Usuario::with('role');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('numero_colaborador', 'like', "%{$search}%")
                    ->orWhere('nombre', 'like', "%{$search}%")
                    ->orWhere('apellidos', 'like', "%{$search}%")
                    ->orWhere('nombre_usuario', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->appends(['search' => $search]);
        $roles = Role::all();

        return view('livewire.admin.user-editor', compact('users', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        if (!auth()->user()->can('user_audit')) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $validated = $request->validate([
            'numero_colaborador' => 'required|numeric|unique:usuarios,numero_colaborador,' . $usuario->id,
            'nombre' => 'required|string|max:50',
            'apellidos' => 'required|string|max:100',
            'nombre_usuario' => 'required|string|max:50|unique:usuarios,nombre_usuario,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario->numero_colaborador = $validated['numero_colaborador'];
        $usuario->nombre = $validated['nombre'];
        $usuario->apellidos = $validated['apellidos'];
        $usuario->nombre_usuario = $validated['nombre_usuario'];
        $usuario->rol_id = $validated['rol_id'];

        if (!empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }

        $usuario->save();

        return redirect()->route('admin.user-editor', ['selected' => $usuario->id])
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        // Prevent deleting yourself
        if ($usuario->id == auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo');
        }

        $usuario->delete();

        return redirect()->route('admin.user-editor')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
