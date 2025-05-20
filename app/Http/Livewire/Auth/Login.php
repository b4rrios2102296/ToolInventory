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

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }

    public function login()
    {
        $this->validate();

        // Buscar usuario por nombre de usuario
        $user = Usuario::where('nombre_usuario', $this->nombre_usuario)->first();

        if ($user && Hash::check($this->password, $user->password)) {
            Auth::login($user, $this->remember);
            return redirect()->intended('/dashboard');
        }

        $this->addError('nombre_usuario', 'Credenciales incorrectas.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Has cerrado sesión exitosamente.');
    }
}
