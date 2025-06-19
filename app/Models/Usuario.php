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
        'password',
        'rol_id',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // In your User model (app/Models/User.php or app/Models/Usuario.php)



    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function permissions()
    {
        // Relación a través del rol
        return $this->role ? $this->role->permisos() : collect();
    }

    // Método existente (sin cambios)
    public function hasPermission(string $clave): bool
    {
        // Verifica si el permiso existe en los permisos del rol
        return $this->role && $this->role->permisos->where('clave', $clave)->isNotEmpty();
    }

    // Añade este método para compatibilidad con @can y middleware
   public function can($ability, $arguments = [])
{
    // Para compatibilidad con @can y Gate
    if ($this->hasPermission($ability)) {
        return true;
    }
    
    // Opcional: lógica adicional si necesitas
    return parent::can($ability, $arguments);
}
}
