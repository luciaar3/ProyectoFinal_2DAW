<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        // 1. Reglas base para TODOS los usuario
        return [
            'nombre'           => ['required', 'string', 'max:255'],
            'primer_apellido'  => ['required', 'string', 'max:255'],
            'segundo_apellido' => ['nullable', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 
                // Excluimos el ID del usuario actual para que pueda guardar su propio email
                Rule::unique('users')->ignore($this->user()->id),],
            'password'         => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        // 2. Reglas extra SOLO si el usuario es Comerciante
        if ($this->user()->rol === 'Comerciante') {
            $rules['nombre_comercio'] = ['required', 'string', 'max:255'];
            $rules['cif']             = ['required', 'string', 'max:50'];
            $rules['direccion']       = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.unique'       => 'Este correo electrónico ya está en uso por otra persona.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            // Mensajes para el comerciante
            'nombre_comercio.required' => 'El nombre del negocio es obligatorio.',
            'cif.required'             => 'El CIF/NIF es obligatorio.',
            'direccion.required'       => 'La dirección es obligatoria.',
        ];
    }
}
