<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos si no existen
        $basicAccess = Permission::firstOrCreate(
            ['clave' => 'basic_access'],
            ['nombre' => 'Acceso básico', 'descripcion' => 'Permiso de acceso básico']
        );

        $userAudit = Permission::firstOrCreate(
            ['clave' => 'user_audit'],
            ['nombre' => 'Auditoría de usuarios', 'descripcion' => 'Ver actividad de usuarios']
        );

        $readAccess = Permission::firstOrCreate(
            ['clave' => 'read_access'],
            ['nombre' => 'Solo lectura', 'descripcion' => 'Permiso para ver datos sin modificarlos']
        );

        // Crear roles si no existen
        $normalRole = Role::firstOrCreate(['nombre' => 'Normal'], ['descripcion' => 'Rol normal']);
        $godRole = Role::firstOrCreate(['nombre' => 'God'], ['descripcion' => 'Rol avanzado']);
        $readRole = Role::firstOrCreate(['nombre' => 'Lectura'], ['descripcion' => 'Rol de solo lectura']);

        // Asignar permisos
        $normalRole->permisos()->sync([$basicAccess->id]);
        $godRole->permisos()->sync([$userAudit->id]);
        $readRole->permisos()->sync([$readAccess->id]);
    }
}
