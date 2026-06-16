<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiteWebsiteResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'caption' => $this->caption,
            'main_image' => $this->imageWithAlt($this->main_image, $this->main_image_alt),
            'meta' => $this->seoMeta('websites'),
        ];
    }
}
