<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image ? url("storage/{$this->image}") : null,
            'is_active' => $this->is_active,
            'role' => $this->role,
            'blogs' => $this->whenLoaded('blogs', function () {
                return BlogResource::collection($this->blogs);
            }),
        ];
    }
}
