<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar primero los permisos y roles
        $this->call(UserRolePermissionSeeder::class);

        // Buscar el rol “God” por nombre
        $rolGod = Role::where('nombre', 'God')->first();

        // Verificar si el usuario ya existe antes de crearlo
        if ($rolGod) {
            $existingUser = Usuario::where('nombre_usuario', 'God')->first();

            if (!$existingUser) {
                Usuario::create([
                    'numero_colaborador' => 1001,
                    'nombre' => 'Admin',
                    'apellidos' => 'Sistemas',
                    'nombre_usuario' => 'God',
                    'password' => bcrypt('password'),
                    'rol_id' => $rolGod->id,
                    'activo' => true
                ]);
            } else {
                \Log::info('El usuario "God" ya existe, no se creó nuevamente.');
            }
        } else {
            \Log::error('El rol "God" no se encontró en la base de datos.');
        }
    }
}
