<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1) Permisos
        $permisos = [
            'ver hospedaje', 'crear hospedaje', 'editar hospedaje', 'eliminar hospedaje',
            'gestionar miembros',
            'ver habitacion', 'crear habitacion', 'editar habitacion', 'eliminar habitacion',
            'crear reserva', 'editar reserva', 'cancelar reserva', 'confirmar reserva',
            'comentar',
            'gestionar usuarios',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2) Roles con sus permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $propietario = Role::firstOrCreate(['name' => 'propietario']);
        $propietario->syncPermissions([
            'ver hospedaje', 'crear hospedaje', 'editar hospedaje', 'eliminar hospedaje',
            'gestionar miembros',
            'ver habitacion', 'crear habitacion', 'editar habitacion', 'eliminar habitacion',
            'confirmar reserva', 'crear reserva', 'cancelar reserva',
            'comentar',
        ]);

        $recepcionista = Role::firstOrCreate(['name' => 'recepcionista']);
        $recepcionista->syncPermissions([
            'ver hospedaje', 'ver habitacion',
            'confirmar reserva', 'editar reserva',
        ]);

        $cliente = Role::firstOrCreate(['name' => 'cliente']);
        $cliente->syncPermissions([
            'ver hospedaje', 'ver habitacion',
            'crear reserva', 'cancelar reserva',
            'comentar',
        ]);

        // 3) Asignar roles a los usuarios del DemoSeeder
        $propietarioDemo = User::where('email', 'propietario@potosi.test')->first();
        $propietarioDemo?->assignRole('propietario');

        $clienteDemo = User::where('email', 'cliente@potosi.test')->first();
        $clienteDemo?->assignRole('cliente');

        // Usuario administrador de prueba
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@potosi.test'],
            ['name' => 'Administrador', 'password' => Hash::make('password')]
        );
        $adminUser->assignRole('admin');
    }
}