<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission; // Importar el modelo Permission

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Definir la relación muchos a muchos con permisos
    public function permisos()
    {
        return $this->belongsToMany(Permission::class, 'rol_permisos', 'rol_id', 'permiso_id');
    }
}
