<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCompactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->appUrl = config('app.url');
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'avatar' => $this->avatar ? $this->appUrl . '/storage/' . $this->avatar : null,
            'created_at' => $this->created,
            'role' => $this->role,
            'company' => CompanyCompactResource::make($this->company),
            'company_role'=>$this?->roles?->role,
        ];
    }
}
