<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserRolePermissionSeeder::class);

        // Buscar el rol "God"
        $rolGod = Role::where('nombre', 'God')->first();

        if ($rolGod) {
            Usuario::firstOrCreate(
                ['nombre_usuario' => 'God'],
                [
                    'numero_colaborador' => 1001,
                    'nombre' => 'Admin',
                    'apellidos' => 'Sistemas',
                    'password' => bcrypt('password'),
                    'rol_id' => $rolGod->id,
                    'activo' => true
                ]
            );
        }
    }
}

