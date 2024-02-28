<?php

namespace App\Http\Resources\Cluster;

use App\Http\Resources\RecordsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClusterRecordsResource extends JsonResource
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
            'name' => $this->name,
            'created' => $this->created,
            'records' => RecordsResource::collection($this->records),
        ];
    }
}
