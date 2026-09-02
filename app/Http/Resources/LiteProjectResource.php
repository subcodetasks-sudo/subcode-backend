<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiteProjectResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'link_project' => $this->link_project,
            'caption' => $this->caption,
            'country' => $this->when($this->country, fn () => [
                'id' => $this->country->id,
                'name' => $this->country->name,
                'code' => $this->country->code,
            ]),
            'main_image' => $this->imageWithAlt($this->main_image, $this->main_image_alt),
            'meta' => $this->seoMeta(),
        ];
    }
}
