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
        $technologies = is_array($this->technologies) ? $this->technologies : [];
        $images = is_array($this->images) ? $this->images : [];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'caption' => $this->caption,
            'long_description' => $this->long_description,
            'technologies' => array_values(array_map(
                fn ($technology) => url('storage/'.$technology),
                array_filter($technologies, fn ($technology) => is_string($technology) && $technology !== '')
            )),
            'main_image' => $this->imageWithAlt($this->main_image, $this->main_image_alt),
            'images' => array_values(array_map(
                fn ($image) => url('storage/'.$image),
                array_filter($images, fn ($image) => is_string($image) && $image !== '')
            )),
            'link_project' => $this->link_project,
            'status' => $this->status,
            'tags' => $this->tags,
            'department' => $this->when($this->department, fn () => [
                'id' => $this->department->id,
                'name' => $this->department->name,
                'slug' => $this->department->slug,
            ]),
            'country' => $this->when($this->country, fn () => [
                'id' => $this->country->id,
                'name' => $this->country->name,
                'code' => $this->country->code,
            ]),
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
