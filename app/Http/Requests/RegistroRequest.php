<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
        $rules = [
        'nombre'           => ['required', 'string', 'max:255'],
        'primer_apellido'  => ['required', 'string', 'max:255'],
        'segundo_apellido' => ['nullable', 'string', 'max:255'],
        'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'         => ['required', 'string', 'min:8', 'confirmed'],
        'rol'              => ['required', 'in:Cliente,Comerciante'],
    ];

    // Validación condicional: solo si es Comerciante
    if ($this->rol === 'Comerciante') {
            $rules['nombre'] = ['required', 'string', 'min:2', 'max:50'];
            $rules['descripcion']    = ['required', 'string', 'min:10', 'max:500'];
            $rules['telefono']       = ['required', 'integer'];
            $rules['nif']            = ['required', 'string', 'size:9', 'unique:negocio,nif'];
            $rules['numero_permiso'] = ['required', 'integer'];
    }

    return $rules;
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.unique'    => 'Este correo electrónico ya está registrado.',
            'password.min'    => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            
            // Mensajes para el negocio
            'nombre_negocio.required' => 'El nombre del negocio es obligatorio.',
            'descripcion.required'    => 'La descripción es obligatoria.',
            'descripcion.min'         => 'La descripción debe tener al menos 10 caracteres.',
            'nif.required'            => 'El NIF es obligatorio.',
            'nif.unique'              => 'Este NIF ya está registrado.',
            'nif.size'                => 'El NIF debe tener 9 caracteres.',
            'numero_permiso.required' => 'El número de permiso municipal es obligatorio.',
            'telefono.required'       => 'El teléfono es obligatorio.',
            'telefono.integer'        => 'El teléfono debe ser un número válido.',
        ];
    }
}
