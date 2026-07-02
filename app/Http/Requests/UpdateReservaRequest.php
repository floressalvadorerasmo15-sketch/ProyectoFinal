<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $reserva = $this->route('reserva');
        return $this->user()->can('update', $reserva);
    }

    public function rules(): array
    {
        return [
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|in:pendiente,confirmada,cancelada,finalizada',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser en el pasado.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ];
    }
}