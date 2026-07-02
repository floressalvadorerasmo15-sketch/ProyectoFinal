<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('comentar');
    }

    public function rules(): array
    {
        return [
            'cuerpo' => 'required|string|min:10|max:1000',
            'calificacion' => 'required|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'cuerpo.min' => 'El comentario debe tener al menos 10 caracteres.',
            'calificacion.min' => 'La calificación mínima es 1 estrella.',
            'calificacion.max' => 'La calificación máxima es 5 estrellas.',
        ];
    }
}