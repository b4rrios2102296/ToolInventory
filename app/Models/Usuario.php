<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

  protected $fillable = [
    'nombre',
    'apellidos',
    'nombre_usuario',
    'email',
    'contraseña_hash',
    'rol_id',
    'numero_colaborador'
];


    protected $hidden = [
        'contraseña_hash',
        'remember_token',
    ];
}
