<?php

namespace Database\Factories;

use App\Models\Reserva;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $inicio = fake()->dateTimeBetween('now', '+2 months');
    $fin = (clone $inicio)->modify('+' . fake()->numberBetween(1, 7) . ' days');

    return [
        'user_id' => \App\Models\User::factory(),
        'habitacion_id' => \App\Models\Habitacion::factory(),
        'fecha_inicio' => $inicio,
        'fecha_fin' => $fin,
        'estado' => fake()->randomElement(['pendiente', 'confirmada', 'cancelada', 'finalizada']),
    ];
    }
}
