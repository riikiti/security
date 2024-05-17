<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Cluster\ClusterResource;
use App\Http\Resources\UserCompactResorce;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyClustersUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => UserCompactResorce::make($this->user),
            'cluster' => ClusterResource::make($this->cluster),
            'is_redactor' => $this->is_redactor,
            'is_reader' => $this->is_reader,
            'is_inviter' => $this->is_inviter,
        ];
    }
}
