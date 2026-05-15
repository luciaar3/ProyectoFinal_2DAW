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

        // Reglas base para TODOS los usuario
        return [
            'nombre'           => ['required', 'string', 'max:255'],
            'primer_apellido'  => ['required', 'string', 'max:255'],
            'segundo_apellido' => ['nullable', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()?->id)],
            'password'         => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:8', 'confirmed'],
            
        ];

    }

    public function messages(): array
    {
        return [
            'nombre.required'           => 'El nombre es obligatorio.',
            'email.unique'              => 'Este correo electrónico ya está en uso.',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
        ];
    }
}
