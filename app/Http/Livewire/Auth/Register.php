<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $numero_colaborador;
    public $nombre;
    public $apellidos;
    public $nombre_usuario;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'numero_colaborador' => 'required|numeric|unique:usuarios',
        'nombre' => 'required|string|max:50',
        'apellidos' => 'required|string|max:100',
        'nombre_usuario' => 'required|string|max:50|unique:usuarios',
        'password' => 'required|string|min:8|confirmed',
        'rol_id' => 'required|exists:roles,id',


    ];

    protected $messages = [
        'numero_colaborador.required' => 'El número de colaborador es obligatorio',
        'numero_colaborador.numeric' => 'El número de colaborador debe ser numérico',
        'numero_colaborador.unique' => 'Este número de colaborador ya está registrado',
        'nombre.required' => 'El nombre es obligatorio',
        'nombre.string' => 'El nombre debe ser texto',
        'nombre.max' => 'El nombre no puede exceder 50 caracteres',
        'apellidos.required' => 'Los apellidos son obligatorios',
        'apellidos.string' => 'Los apellidos deben ser texto',
        'apellidos.max' => 'Los apellidos no pueden exceder 100 caracteres',
        'nombre_usuario.required' => 'El nombre de usuario es obligatorio',
        'nombre_usuario.string' => 'El nombre de usuario debe ser texto',
        'nombre_usuario.max' => 'El nombre de usuario no puede exceder 50 caracteres',
        'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso',
        'password.required' => 'La contraseña es obligatoria',
        'password.string' => 'La contraseña debe ser texto',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        'password.confirmed' => 'Las contraseñas no coinciden',
        'rol_id.required' => 'Seleccionar un rol es obligatorio',

    ];

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.guest');
    }

    public function register()
    {
        $this->validate();

        Usuario::create([
            'numero_colaborador' => $this->numero_colaborador,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'nombre_usuario' => $this->nombre_usuario,
            'password' => Hash::make($this->password),
            'rol_id' => $this->rol_id,
            'activo' => true,
        ]);
        session()->flash('message', 'Registro exitoso. Por favor inicia sesión.');

        return redirect()->to('/login');
    }

    public $rol_id;
    public $roles = [];

    public function mount()
    {
        $this->roles = \App\Models\Role::all();
    }

}