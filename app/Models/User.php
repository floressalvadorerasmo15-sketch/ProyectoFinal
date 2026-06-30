<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function hospedajesPropios(): HasMany
    {
    return $this->hasMany(Hospedaje::class, 'owner_id');
    }

    public function hospedajes(): BelongsToMany
    {
    return $this->belongsToMany(Hospedaje::class, 'hospedaje_user')
        ->withPivot('rol_hospedaje')
        ->withTimestamps();
    }

    public function reservas(): HasMany
    {
    return $this->hasMany(Reserva::class);
    }

    public function comentarios(): HasMany
    {
    return $this->hasMany(Comentario::class);
    }
}
