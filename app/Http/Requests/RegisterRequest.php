<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password'=>'required',
            'confirm_password'=>'required|same:password',
            'role'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'error',
            'email.unique' => 'Данная почта уже зарегистрирована на сайте',
        ];
    }
}
