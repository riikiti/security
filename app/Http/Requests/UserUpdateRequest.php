<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            //'user_id' => 'required|exists:users,id',
            'name' => 'string|nullable',
            'avatar' => 'nullable',
            'email' => 'email|nullable',
            'password' => 'nullable|string',
            'password_confirmed' => 'nullable|same:password',
            'role_id' => 'integer|nullable',
        ];
    }
}
