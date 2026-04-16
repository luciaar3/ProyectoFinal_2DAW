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
        'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'         => ['required', 'string', 'min:8', 'confirmed'],
        'rol'              => ['required', 'in:Cliente,Comerciante'],
    ];

    // Validación condicional: solo si es Comerciante
    if ($this->rol === 'Comerciante') {
        $rules['nombre_negocio'] = ['required', 'string', 'min:2', 'max:50'];
        $rules['descripcion']    = ['required', 'string', 'min:10', 'max:500'];
        $rules['ciudad']         = ['required', 'string'];
        $rules['numero_puesto']  = ['required','string', 'max:20'];
        $rules['telefono']       = ['required', 'integer'];
    }

    return $rules;
    }

    public function messages(): array
    {
        return [
            // Mensajes para el Nombre
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',

            // Mensajes para el Primer Apellido
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'primer_apellido.string' => 'El primer apellido debe ser un texto válido.',
            'primer_apellido.max' => 'El primer apellido no puede superar los 255 caracteres.',

            // Mensajes para el Segundo Apellido
            'segundo_apellido.string' => 'El segundo apellido debe ser un texto válido.',
            'segundo_apellido.max' => 'El segundo apellido no puede superar los 255 caracteres.',

            // Mensajes para el Email
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes introducir un formato de correo válido (ejemplo@correo.com).',
            'email.unique' => 'Este correo electrónico ya está registrado en nuestro sistema.',
            'email.max' => 'El correo electrónico es demasiado largo.',

            // Mensajes para la Contraseña
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres por seguridad.',
            'password.confirmed' => 'Las contraseñas no coinciden. Por favor, vuelve a escribirlas.',

            // Mensajes para el Rol
            'rol.required' => 'Debes seleccionar qué tipo de cuenta deseas crear.',
            'rol.in' => 'El tipo de cuenta seleccionado no es válido. Debe ser "Cliente" o "Comerciante".',

            'numero_puesto.required' => 'El número de puesto es obligatorio para comerciantes.',
        ];
    }
}
