<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'long_description' => $this->long_description,
            'technologies' => $this->technologies ? array_map(function ($technology) {
                return url("storage/{$technology}");
            }, $this->technologies) : [],
            'main_image' => $this->imageWithAlt($this->main_image, $this->main_image_alt),
            'images' => $this->images ? array_map(function ($image) {
                return url("storage/{$image}");
            }, $this->images) : [],
            'link_project' => $this->link_project,
            'status' => $this->status,
            'tags' => $this->tags,
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
                'slug' => $this->department->slug,
            ],
            'advantage_projects' => $this->whenLoaded('advantageProjects', function () {
                return AdvantageProjectResource::collection($this->advantageProjects);
            }),
            'review_projects' => $this->whenLoaded('reviewProjects', function () {
                return ReviewProjectResource::collection($this->reviewProjects);
            }),
            'meta' => $this->seoMeta('projects'),
        ];
    }
}
