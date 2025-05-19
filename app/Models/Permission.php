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

    public function rol()
{
    return $this->belongsToMany(Role::class, 'rol_id');
}

}