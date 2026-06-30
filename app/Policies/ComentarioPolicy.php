<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\User;

class ComentarioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comentario $comentario): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('comentar');
    }

    public function update(User $user, Comentario $comentario): bool
    {
        return $user->hasRole('admin') || $comentario->user_id === $user->id;
    }

    public function delete(User $user, Comentario $comentario): bool
    {
        return $user->hasRole('admin') || $comentario->user_id === $user->id;
    }
}