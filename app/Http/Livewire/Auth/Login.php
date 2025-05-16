<?php
namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component

{
    public $nombre_usuario;
    public $password;
    public $remember = false;

    protected $rules = [
        'nombre_usuario' => 'required',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt([
            'nombre_usuario' => $this->nombre_usuario,
            'password' => $this->password
        ], $this->remember)) {
            return redirect()->intended('/dashboard');
        }

        $this->addError('nombre_usuario', 'Credenciales incorrectas');
    }
}
