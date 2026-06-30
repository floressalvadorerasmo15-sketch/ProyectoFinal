<?php

namespace Database\Factories;

use App\Models\Hospedaje;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hospedaje>
 */
class HospedajeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'owner_id' => \App\Models\User::factory(),
        'nombre' => fake()->company() . ' Hospedaje',
        'descripcion' => fake()->paragraph(),
        'direccion' => fake()->address(),
        'estado' => fake()->randomElement(['activo', 'inactivo', 'pendiente']),
    ];
    }
}
