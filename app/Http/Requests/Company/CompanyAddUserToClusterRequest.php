<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAddUserToClusterRequest extends FormRequest
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
            'cluster_id' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'is_redactor' => 'nullable',
            'is_reader' => 'nullable',
            'is_inviter' => 'nullable',
        ];
    }
}
