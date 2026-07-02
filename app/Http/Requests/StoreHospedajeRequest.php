<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospedajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('crear hospedaje');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|in:activo,inactivo,pendiente',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ];
    }
}