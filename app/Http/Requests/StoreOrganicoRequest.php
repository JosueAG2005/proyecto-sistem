<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:organicos,nombre',
            'categoria_id' => 'required|exists:categorias,id',

            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',

            'fecha_cosecha' => 'nullable|date',
            'descripcion' => 'nullable|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
        ];
    }
}
