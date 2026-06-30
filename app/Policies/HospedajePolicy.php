<?php

namespace App\Policies;

use App\Models\Reserva;
use App\Models\User;

class ReservaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Reserva $reserva): bool
    {
        return $user->hasRole('admin')
            || $user->hasRole('recepcionista')
            || $reserva->user_id === $user->id
            || $reserva->habitacion->hospedaje->owner_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('crear reserva');
    }

    public function update(User $user, Reserva $reserva): bool
    {
        return $user->hasRole('admin')
            || ($user->can('editar reserva')
                && ($user->hasRole('recepcionista') || $reserva->habitacion->hospedaje->owner_id === $user->id));
    }

    public function cancel(User $user, Reserva $reserva): bool
    {
        return $user->hasRole('admin')
            || $reserva->user_id === $user->id
            || $reserva->habitacion->hospedaje->owner_id === $user->id;
    }

    public function confirm(User $user, Reserva $reserva): bool
    {
        return $user->hasRole('admin')
            || ($user->can('confirmar reserva')
                && ($user->hasRole('recepcionista') || $reserva->habitacion->hospedaje->owner_id === $user->id));
    }
}