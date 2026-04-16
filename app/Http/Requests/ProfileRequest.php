<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        return [
            'nombre'           => ['required', 'string', 'max:255'],
            'primer_apellido'  => ['required', 'string', 'max:255'],
            'segundo_apellido' => ['nullable', 'string', 'max:255'],
            // Usamos $this->user()?->id para que funcione tanto en registro (null) como en edición
            'email'            => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()?->id)],
            'password'         => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:8', 'confirmed'],
            
            // Datos del Negocio (Ajustados a tu tabla NEGOCIO_COMERCIO)
            'nombre_negocio'   => ['required', 'string', 'min:2', 'max:50'],
            'descripcion'      => ['required', 'string', 'min:10', 'max:500'],
            'ciudad'           => ['required', 'string', 'min:5', 'max:100'],
            'numero_puesto'    => ['required','string', 'max:20'],
            'telefono'         => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            // Errores básicos
            'nombre.required'           => 'El nombre es obligatorio.',
            'email.unique'              => 'Este correo electrónico ya está en uso.',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
            
            // Mensajes para el negocio (Actualizados con tus campos nuevos)
            'nombre_negocio.required'   => 'El nombre del negocio es obligatorio.',
            'descripcion.required'      => 'La descripción es necesaria.',
            'descripcion.min'           => 'La descripción debe ser más detallada (mínimo 10 caracteres).',
            'ciudad.required'           => 'La ciudad es obligatoria.',
            'numero_puesto.required'           => 'El número es obligatorio.',
            'telefono.required'         => 'El teléfono es obligatorio.',
            'telefono.integer'          => 'El teléfono debe ser un número válido.',
        ];
    }
}
