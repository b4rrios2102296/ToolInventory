<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar primero los seeders de permisos y roles
        $this->call(UserRolePermissionSeeder::class);

        // Buscar los roles
        $roles = [
            'God' => Role::where('nombre', 'God')->first(),
            'Normal' => Role::where('nombre', 'Normal')->first(),
            'Lectura' => Role::where('nombre', 'Lectura')->first(),
        ];

        // Definir usuarios con sus respectivos roles
        $usuarios = [
            [
                'numero_colaborador' => 1001,
                'nombre' => 'Admin',
                'apellidos' => 'Sistemas',
                'nombre_usuario' => 'God',
                'password' => bcrypt('password'),
                'rol_id' => $roles['God']?->id,
                'activo' => true,
            ],
            [
                'numero_colaborador' => 1002,
                'nombre' => 'Usuario',
                'apellidos' => 'Normal',
                'nombre_usuario' => 'NormalUser',
                'password' => bcrypt('password'),
                'rol_id' => $roles['Normal']?->id,
                'activo' => true,
            ],
            [
                'numero_colaborador' => 1003,
                'nombre' => 'Usuario',
                'apellidos' => 'Lectura',
                'nombre_usuario' => 'LecturaUser',
                'password' => bcrypt('password'),
                'rol_id' => $roles['Lectura']?->id,
                'activo' => true,
            ],
        ];

        // Crear usuarios si no existen
        foreach ($usuarios as $usuario) {
            Usuario::firstOrCreate(
                ['nombre_usuario' => $usuario['nombre_usuario']],
                $usuario
            );
        }
    }
}

