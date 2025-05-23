<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_colaborador' => $this->faker->unique()->randomNumber(5),
            'nombre' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'nombre_usuario' => $this->faker->unique()->userName,
            'password' => static::$password ??= Hash::make('password'),
            'rol_id' => 2,
            'activo' => true,
            'remember_token' => Str::random(10),
        ];
    }
}
