<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'habitaciones';

    protected $fillable = [
        'hospedaje_id',
        'numero',
        'tipo',
        'precio',
        'capacidad',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'capacidad' => 'integer',
    ];

    public function hospedaje(): BelongsTo
    {
        return $this->belongsTo(Hospedaje::class);
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}