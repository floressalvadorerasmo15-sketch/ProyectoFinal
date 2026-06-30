<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Servicio>
 */
class ServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'nombre' => fake()->randomElement([
            'WiFi gratuito', 'Desayuno incluido', 'Televisión por cable',
            'Agua caliente', 'Lavandería', 'Servicio de taxi',
            'Información turística', 'Recepción 24 horas',
            'Habitaciones familiares', 'Vista panorámica',
        ]),
        'descripcion' => fake()->sentence(),
    ];
    }
}
