<?php

namespace App\Http\Requests\Cluster;

use Illuminate\Foundation\Http\FormRequest;

class ClusterRequest extends FormRequest
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
            'cluster_id' => 'required|exists:clusters,id|integer',
            'password' => 'string|required',
            'name' => 'nullable|string',
            'new_password' => 'nullable|string',
            'new_password_confirm' => 'nullable|string|same:new_password',
        ];
    }
}
