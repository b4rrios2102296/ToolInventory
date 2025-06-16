<?php
namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class Login extends Component
{
    public $nombre_usuario;
    public $password;
    public $remember = false;

    protected $rules = [
        'nombre_usuario' => 'required|string',
        'password' => 'required|min:8',
    ];

    protected $messages = [
        'nombre_usuario.required' => 'El nombre de usuario es obligatorio',
        'password.required' => 'La contraseña es obligatoria',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres',
    ];

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }

    public function login()
    {
        $this->validate();

        $user = Usuario::where('nombre_usuario', $this->nombre_usuario)->first();

        if (!$user) {
            $this->addError('nombre_usuario', 'Credenciales incorrectas');
            return;
        }

        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', 'Contraseña incorrecta');
            return;
        }

        Auth::login($user, $this->remember);
        
        return redirect()->intended('/dashboard')
            ->with('success', '¡Bienvenido de nuevo!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')
            ->with('status', 'Has cerrado sesión exitosamente.');
    }
}