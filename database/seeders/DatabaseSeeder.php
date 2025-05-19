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

        // Crear el usuario solo si el rol existe
        if ($rolGod) {
            Usuario::create([
                'numero_colaborador' => 1001,
                'nombre' => 'Admin',
                'apellidos' => 'Sistema',
                'nombre_usuario' => 'admin',
                'email' => 'admin@example.com',
                'contraseña_hash' => bcrypt('password'),
                'rol_id' => $rolGod->id,
                'activo' => true
            ]);
        } else {
            // Puedes lanzar una excepción o loggear si no se encuentra el rol
            \Log::error('El rol "God" no se encontró en la base de datos.');
        }
    }
}

