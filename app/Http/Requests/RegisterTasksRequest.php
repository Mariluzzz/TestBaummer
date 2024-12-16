<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RegisterTasksRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
    * Determine if the user is authorized to make this request.
    */
    public function createDateFromFormat($date) {
        $format = strpos($date, 'T') !== false ? 'Y-m-d\TH:i' : 'd/m/Y H:i';
        return Carbon::createFromFormat($format, $date);
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
    public function rules(): array
    {
        $deadline = $this->input('deadline');
        $executed_at = $this->input('executed_at');

        if (!empty($deadline)) {
            $deadline = $this->createDateFromFormat($deadline);
        }
        
        if (!empty($executed_at)) {
            $executed_at = $this->createDateFromFormat($executed_at);
        }

        $this->merge([
            'deadline' => $deadline->toDateTimeString(),
            'executed_at' => $executed_at,
        ]);

        return [
            'description' => 'required|string|max:255',
            'deadline' => 'required|date|after:' . Carbon::now()->addHours(24)->toDateTimeString(),
            'collaborator_name' => 'required',
            'priority' => 'required|in:baixa,média,alta',
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
            'description.required' => 'O campo descrição é obrigatório.',
            'deadline.required' => 'O campo data prazo é obrigatório.',
            'deadline.after' => 'O prazo limite deve ser pelo menos 24 horas à frente da data/hora atual.',
            'collaborator_name.required' => 'O campo responsável é obrigatório.',
            'priority.required' => 'O campo prioridade é obrigatório.',
        ];
    }
}
