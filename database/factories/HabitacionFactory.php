<?php

namespace Database\Factories;

use App\Models\Habitacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Habitacion>
 */
class HabitacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'hospedaje_id' => \App\Models\Hospedaje::factory(),
        'numero' => fake()->numerify('###'),
        'tipo' => fake()->randomElement(['simple', 'doble', 'suite', 'familiar']),
        'precio' => fake()->randomFloat(2, 80, 600),
        'capacidad' => fake()->numberBetween(1, 6),
        'estado' => fake()->randomElement(['disponible', 'ocupada', 'mantenimiento']),
    ];
    }
}
