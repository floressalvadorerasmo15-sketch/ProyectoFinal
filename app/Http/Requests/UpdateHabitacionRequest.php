<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHabitacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $habitacion = $this->route('habitacion');
        return $this->user()->can('update', $habitacion);
    }

    public function rules(): array
    {
        return [
            'numero' => 'required|string|max:10',
            'tipo' => 'required|in:simple,doble,suite,familiar',
            'precio' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1|max:20',
            'estado' => 'required|in:disponible,ocupada,mantenimiento',
        ];
    }
}