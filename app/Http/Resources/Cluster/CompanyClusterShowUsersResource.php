<?php

namespace App\Http\Resources\Cluster;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyClusterShowUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cluster' => $this->cluster,
            'users' => $this?->user,
            'is_redactor' => $this->is_redactor,
            'is_reader' => $this->is_reader,
            'is_inviter' => $this->is_inviter,
        ];
    }
}
