<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHabitacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('crear habitacion');
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