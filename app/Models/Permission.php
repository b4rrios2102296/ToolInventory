<?php

// app/Models/Permission.php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permisos'; // Especifica el nombre correcto de la tabla

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rol_permisos', 'permiso_id', 'rol_id');
    }


}