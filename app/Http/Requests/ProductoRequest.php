<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'      => 'required|string|max:255',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'etiqueta_nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'categoria'   => 'nullable|string',
            'imagen'      => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'Debes asignar un precio.',
            'precio.numeric'  => 'El precio debe ser un número válido.',
            'stock.required'  => 'Indica cuántas unidades tienes disponibles.',
            'imagen.image'    => 'El archivo debe ser una imagen válida.'
        ];
    }
}
