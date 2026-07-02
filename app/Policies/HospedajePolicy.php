<?php

namespace App\Policies;

use App\Models\Hospedaje;
use App\Models\User;

class HospedajePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Hospedaje $hospedaje): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('crear hospedaje');
    }

    public function update(User $user, Hospedaje $hospedaje): bool
    {
        return $user->hasRole('admin')
            || ($user->can('editar hospedaje') && $hospedaje->owner_id === $user->id);
    }

    public function delete(User $user, Hospedaje $hospedaje): bool
    {
        return $user->hasRole('admin')
            || ($user->can('eliminar hospedaje') && $hospedaje->owner_id === $user->id);
    }

    public function gestionarMiembros(User $user, Hospedaje $hospedaje): bool
    {
        return $user->hasRole('admin')
            || ($user->can('gestionar miembros') && $hospedaje->owner_id === $user->id);
    }
}