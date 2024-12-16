<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCollaboratorsRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'cpf' => 'required|min:11|max:11|unique:collaborators',
            'email' => 'required|email|unique:collaborators,email',
        ];
    }

    /**
    * Get the custom validation messages.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'cpf.required' => 'O campo senha é obrigatório.',
            'cpf.min' => 'O cpf deve ter 11 caracteres.',
            'cpf.max' => 'O cpf deve ter 11 caracteres.',
            'cpf.unique' => 'Este cpf já está em uso.',
        ];
    }
}
