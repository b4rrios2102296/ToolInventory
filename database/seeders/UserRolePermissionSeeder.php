<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class UserRolePermissionSeeder extends Seeder
{
    // database/seeders/UserRolePermissionSeeder.php
public function run()
{
     \DB::table('rol_permisos')->delete();
    \DB::table('permisos')->delete();
    \DB::table('roles')->delete();
    // Usar firstOrCreate para evitar duplicados
    $basicAccess = Permission::firstOrCreate(
        ['clave' => 'basic_access'],
        ['nombre' => 'Basic Access']
    );
    
    $userAudit = Permission::firstOrCreate(
        ['clave' => 'user_audit'],
        ['nombre' => 'User Audit']
    );

    // Crear roles si no existen
    $normalRole = Role::firstOrCreate(
        ['nombre' => 'Normal'],
        ['descripcion' => 'Normal user']
    );
    
    $godRole = Role::firstOrCreate(
        ['nombre' => 'God'],
        ['descripcion' => 'Super admin']
    );

    // Sincronizar permisos (evita duplicados en la tabla pivote)
    $normalRole->permisos()->syncWithoutDetaching([$basicAccess->id]);
    $godRole->permisos()->syncWithoutDetaching(Permission::pluck('id')->toArray());

    // Crear usuarios solo si no existen

}
}