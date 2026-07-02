<?php

namespace App\Http\Requests;

use App\Models\Reserva;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('crear reserva');
    }

    public function rules(): array
    {
        return [
            'habitacion_id' => [
                'required',
                'exists:habitaciones,id',
                function ($attribute, $value, $fail) {
                    $conflicto = Reserva::where('habitacion_id', $value)
                        ->whereNotIn('estado', ['cancelada'])
                        ->where(function ($query) {
                            $query->whereBetween('fecha_inicio', [$this->fecha_inicio, $this->fecha_fin])
                                ->orWhereBetween('fecha_fin', [$this->fecha_inicio, $this->fecha_fin])
                                ->orWhere(function ($q) {
                                    $q->where('fecha_inicio', '<=', $this->fecha_inicio)
                                        ->where('fecha_fin', '>=', $this->fecha_fin);
                                });
                        })->exists();

                    if ($conflicto) {
                        $fail('La habitación ya está reservada en esas fechas.');
                    }
                },
            ],
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'habitacion_id.required' => 'Debe seleccionar una habitación.',
        ];
    }
}