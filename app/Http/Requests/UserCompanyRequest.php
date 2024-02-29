<?php

namespace App\Http\Requests;

use App\Enum\CompanyRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;

class UserCompanyRequest extends FormRequest
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
            //'user_id' => 'integer|required|exists:users,id',
            'company_id' => 'integer|required|exists:companies,id',
            'company_role' => 'nullable|exists:companies,id',

        ];
    }
}
