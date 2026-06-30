<?php

namespace App\Policies;

use App\Models\Habitacion;
use App\Models\User;

class HabitacionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Habitacion $habitacion): bool
    {
        return true;
    }

    public function create(User $user, Habitacion $habitacion = null): bool
    {
        return $user->can('crear habitacion');
    }

    public function update(User $user, Habitacion $habitacion): bool
    {
        return $user->hasRole('admin')
            || ($user->can('editar habitacion') && $habitacion->hospedaje->owner_id === $user->id);
    }

    public function delete(User $user, Habitacion $habitacion): bool
    {
        return $user->hasRole('admin')
            || ($user->can('eliminar habitacion') && $habitacion->hospedaje->owner_id === $user->id);
    }
}