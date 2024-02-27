<?php

namespace App\Http\Requests\Records;

use Illuminate\Foundation\Http\FormRequest;

class RecordsStoreRequest extends FormRequest
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
            'email' => 'nullable|string|email',
            'login' => 'nullable|string',
            'password' => 'nullable|string',
            'cluster_id' => 'required|integer',
            'site' => 'nullable|string'
        ];
    }
}
