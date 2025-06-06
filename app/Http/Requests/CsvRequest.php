<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvRequest extends FormRequest
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
            'file' => 'required|mimes:csv,txt|max:2048',
        ];
    }

    public function messages(): array{
        return [
            'file.required' => 'o campo arquivo é obrigatório',
            'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV!',
            'file.max' => 'Tamanho do arquivo execede :max Mb',

        ];
    }
}
