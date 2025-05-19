<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;



class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'numero_colaborador',
        'nombre',
        'apellidos',
        'nombre_usuario',
        'email',
        'password',
        'rol_id',
        'activo',
    ];

protected $hidden = [
    'password',
    'remember_token',
];

    // In your User model (app/Models/User.php or app/Models/Usuario.php)
public function hasPermission(string $clave): bool
{
    return $this->permissions()->where('clave', $clave)->exists();
}


public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function permissions()
    {
        return $this->role->permissions();
    }
}
