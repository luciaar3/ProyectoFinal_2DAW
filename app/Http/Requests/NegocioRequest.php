<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NegocioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo permitimos si el usuario tiene un negocio
        return Auth::user()->negocio !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $negocioId = Auth::user()->negocio->id;

        return [
            'nombre'         => ['required', 'string', 'max:50'],
            'descripcion'    => ['required', 'string', 'max:500'],
            'telefono'       => ['required', 'integer'],
            'numero_permiso' => ['required', 'integer'],
            'nif'            => ['required', 'string', 'size:9', 'unique:negocio,nif,' . $negocioId],
            'imagen'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'      => 'El nombre del negocio es obligatorio.',
            'nif.unique'           => 'Este NIF ya está registrado por otro comercio.',
            'imagen.image'         => 'El archivo debe ser una imagen.',
            'imagen.max'           => 'La imagen no puede pesar más de 2MB.',
            'numero_permiso.required' => 'El número de permiso es obligatorio.',
        ];
    }
}
