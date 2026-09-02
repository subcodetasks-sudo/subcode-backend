<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        $base = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => $this->imageWithAlt($this->image, $this->image_alt),
            'status' => $this->status,
            'time_publish' => $this->time_publish,
            'is_active' => $this->is_active,
            'meta' => $this->seoMeta('blogs'),
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
                'image' => $this->imageWithAlt($this->category->image, $this->category->image_alt),
            ],
            'author' => $this->whenLoaded('author'),
            'created_at' => $this->created_at,
        ];

        return $base;
    }
}
