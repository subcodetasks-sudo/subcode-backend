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

        if ($request->route()?->getName() === 'blog.single') {
            $base['also_like'] = \App\Models\Blog::where('is_active', 1)
                ->where('status', 'publish')
                ->where('category_id', $this->category_id)
                ->where('id', '!=', $this->id)
                ->inRandomOrder()
                ->take(3)
                ->get()
                ->map(function ($blog) {
                    return [
                        'id' => $blog->id,
                        'title' => $blog->title,
                        'description' => $blog->description,
                        'slug' => $blog->slug,
                        'image' => $blog->image ? url("storage/{$blog->image}") : null,
                        'created_at' => $blog->created_at,
                    ];
                });
        }

        return $base;
    }
}
