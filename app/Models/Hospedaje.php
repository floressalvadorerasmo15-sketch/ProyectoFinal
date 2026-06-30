<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospedaje extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'nombre',
        'descripcion',
        'direccion',
        'estado',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function habitaciones(): HasMany
    {
        return $this->hasMany(Habitacion::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'hospedaje_user')
            ->withPivot('rol_hospedaje')
            ->withTimestamps();
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'hospedaje_servicio')
            ->withTimestamps();
    }
}
