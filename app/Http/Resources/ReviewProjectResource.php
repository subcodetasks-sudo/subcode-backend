<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewProjectResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->imageWithAlt($this->image, $this->image_alt),
            'project_name' => $this->project_name,
            'project_image' => $this->imageWithAlt($this->project_image, $this->project_image_alt),
            'project' => $this->whenLoaded('project'),
        ];
    }
}
