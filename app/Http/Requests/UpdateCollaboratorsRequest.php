<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Collaborators;

class UpdateCollaboratorsRequest extends FormRequest
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
        $collaboratorId = $this->route('id');
        $collaborator = Collaborators::findOrFail($collaboratorId);

        return [
            'name' => 'required|string|max:255',
            'cpf' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('collaborators', 'cpf')->ignore($collaboratorId)->where(function ($query) use ($collaborator) {
                    return $query->where('cpf', '!=', $collaborator->cpf);
                }),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('collaborators', 'email')->ignore($collaboratorId)->where(function ($query) use ($collaborator) {
                    return $query->where('email', '!=', $collaborator->email);
                }),
            ],
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
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.min' => 'O CPF deve ter 11 caracteres.',
            'cpf.max' => 'O CPF deve ter 11 caracteres.',
            'cpf.unique' => 'O CPF já está cadastrado para outro colaborador.',
            'email.unique' => 'O E-mail já está cadastrado para outro colaborador.',
        ];
    }
}
