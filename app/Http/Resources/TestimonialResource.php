<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client_name' => $this->client_name,
            'description' => $this->description,
            'client_image' => $this->imageWithAlt($this->client_image, $this->client_image_alt),
            'project_image' => $this->imageWithAlt($this->project_image, $this->project_image_alt),
            'project_name' => $this->project_name,
            'meta' => $this->seoMeta(),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
