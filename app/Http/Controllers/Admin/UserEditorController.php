<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // Agregar esta importación

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
            $query->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*') // Solo selecciona columnas de usuarios
                ->where(function ($q) use ($search) {
                    $q->where('usuarios.numero_colaborador', 'like', "%{$search}%")
                        ->orWhere('usuarios.nombre', 'like', "%{$search}%")
                        ->orWhere('usuarios.apellidos', 'like', "%{$search}%")
                        ->orWhere('usuarios.nombre_usuario', 'like', "%{$search}%")
                        ->orWhere('roles.nombre', 'like', "%{$search}%"); // Búsqueda por nombre del rol
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

        try {
            $validated = $request->validate([
                'numero_colaborador' => 'required|numeric|unique:usuarios,numero_colaborador,' . $usuario->id,
                'nombre' => 'required|string|max:50',
                'apellidos' => 'required|string|max:100',
                'nombre_usuario' => 'required|string|max:50|unique:usuarios,nombre_usuario,' . $usuario->id,
                'password' => 'nullable|string|min:8|confirmed',
                'rol_id' => 'required|exists:roles,id',
            ], [
                'password.confirmed' => 'Las contraseñas no coinciden'
            ]);

            $usuario->numero_colaborador = $validated['numero_colaborador'];
            $usuario->nombre = $validated['nombre'];
            $usuario->apellidos = $validated['apellidos'];
            $usuario->nombre_usuario = $validated['nombre_usuario'];
            $usuario->rol_id = $validated['rol_id'];

            $isAuditUser = auth()->user()->role->nombre === 'Auditor';
            $isEditingSelf = auth()->id() == $usuario->id;

            if ($isAuditUser && $isEditingSelf) {
                $validated['rol_id'] = $usuario->rol_id; // Mantener el rol actual
            }

            if (!empty($validated['password'])) {
                $usuario->password = Hash::make($validated['password']);
            }

            $usuario->save();

            return redirect()->route('admin.user-editor', ['selected' => $usuario->id])
                ->with('success', 'Usuario actualizado correctamente.');

        } catch (ValidationException $e) {
            // Capturar específicamente el error de confirmación de contraseña
            if ($e->validator->errors()->has('password')) {
                return back()->with('error', 'Las contraseñas no coinciden')->withInput();
            }

            // Para otros errores de validación
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id == auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo');
        }

        $usuario->delete();

        return redirect()->route('admin.user-editor')
            ->with('success', 'Usuario eliminado correctamente');
    }
}