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
            'rol_id' => 2, // Rol por defecto (Normal)
            'activo' => true,
        ]);

        session()->flash('message', 'Registro exitoso. Por favor inicia sesión.');

        return redirect()->to('/login');
    }
}
