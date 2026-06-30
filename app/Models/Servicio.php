<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function hospedajes(): BelongsToMany
    {
        return $this->belongsToMany(Hospedaje::class, 'hospedaje_servicio')
            ->withTimestamps();
    }
}