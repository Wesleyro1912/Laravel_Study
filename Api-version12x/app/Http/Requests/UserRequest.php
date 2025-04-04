<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . ($user ? $user->id),
            'password' => 'required_if:password,!=,null|min:6',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Campo nome é obrigatório', 
            'email.required' => 'Campo email é obrigatório', 
            'email.email' => 'Campo email não é válido',
            'email.unique' => 'Campo email deve ser unico', 
            'password.required_if' => 'Campo de senha é obrigatório',
            'password.min' => 'Campo de senha deve ter no minimo :min',
        ];
    }
}
