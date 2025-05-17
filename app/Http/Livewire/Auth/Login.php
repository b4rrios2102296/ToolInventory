<?php
namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class Login extends Component{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
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

        // Retrieve user by email
        $user = Usuario::where('email', $this->email)->first();

        if ($user && Hash::check($this->password, $user->contraseña_hash)) {
            Auth::login($user, $this->remember);
            return redirect()->intended('/dashboard');
        }
        $this->addError('email', 'Credenciales incorrectas.');
    }public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'You have been successfully logged out.');
    }
}
