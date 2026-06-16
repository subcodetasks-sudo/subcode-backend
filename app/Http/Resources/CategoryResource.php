<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->imageWithAlt($this->image, $this->image_alt),
            'meta' => $this->seoMeta(),
            'blogs' => $this->whenLoaded('blogs', function () {
                return BlogResource::collection($this->blogs);
            }),
            'blogs_count' => $this->when(isset($this->blogs_count), $this->blogs_count),
        ];
    }
}
