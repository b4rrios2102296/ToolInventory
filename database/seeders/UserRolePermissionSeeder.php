<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Buscar los roles
        $normalRole = Role::where('nombre', 'Normal')->first();
        $godRole = Role::where('nombre', 'God')->first();

        // Buscar los permisos
        $basicAccess = Permission::where('clave', 'basic_access')->first();
        $userAudit = Permission::where('clave', 'user_audit')->first();

        // Si existen los roles y permisos, asignar SOLO el permiso correspondiente a cada rol
        if ($normalRole && $basicAccess) {
            $normalRole->permisos()->sync([$basicAccess->id]); // Solo "basic_access" para "Normal"
        }

        if ($godRole && $userAudit) {
            $godRole->permisos()->sync([$userAudit->id]); // Solo "user_audit" para "God"
        }
    }
}
