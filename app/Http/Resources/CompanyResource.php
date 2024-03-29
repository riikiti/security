<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'owner' => UserResource::make($this->owner),
            'avatar' => $this->logo ? $this->appUrl . '/storage/' . $this->logo : null,
        ];
    }
}
