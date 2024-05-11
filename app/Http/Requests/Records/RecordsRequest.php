<?php

namespace App\Http\Requests\Records;

use Illuminate\Foundation\Http\FormRequest;

class RecordsRequest extends FormRequest
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
            'record_id' => 'required|exists:records,id|integer',
            'email' => 'nullable|string|email',
            'login' => 'nullable|string',
            'site' => 'nullable|string',
            'password' => 'nullable|string',
            'color' => 'nullable|string',
            'title' => 'nullable|string',
        ];
    }
}
