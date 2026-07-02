<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\Habitacion;
use App\Models\Hospedaje;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = collect([
            'WiFi gratuito', 'Desayuno incluido', 'Televisión por cable',
            'Agua caliente', 'Lavandería', 'Servicio de taxi',
            'Información turística', 'Recepción 24 horas',
        ])->map(fn ($nombre) => Servicio::firstOrCreate(['nombre' => $nombre]));

        $propietario = User::factory()->create([
            'name' => 'Propietario',
            'email' => 'propietario@potosi.test',
            'password' => Hash::make('Prop2026'),
        ]);

        $cliente = User::factory()->create([
            'name' => 'Cliente',
            'email' => 'cliente@potosi.test',
            'password' => Hash::make('Clien2026'),
        ]);

        Hospedaje::factory(5)
            ->create(['owner_id' => $propietario->id])
            ->each(function (Hospedaje $hospedaje) use ($servicios, $cliente) {
                Habitacion::factory(3)->create(['hospedaje_id' => $hospedaje->id]);

                $hospedaje->servicios()->attach(
                    $servicios->random(rand(2, 4))->pluck('id')
                );

                $hospedaje->usuarios()->attach($hospedaje->owner_id, [
                    'rol_hospedaje' => 'propietario',
                ]);

                Comentario::factory()->create([
                    'user_id' => $cliente->id,
                    'hospedaje_id' => $hospedaje->id,
                ]);
            });
    }
}