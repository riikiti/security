<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordsResource extends JsonResource
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
            'email' => $this->email,
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'title' => $this->title,
            'color' => $this->color,
        ];
    }
}
