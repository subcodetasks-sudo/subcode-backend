<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteResource extends JsonResource
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
            'image' => $this->imageWithAlt($this->image, null),
            'main_image' => $this->imageWithAlt($this->main_image, $this->main_image_alt),
            'images' => $this->images ? array_map(function ($image) {
                return url("storage/{$image}");
            }, $this->images) : [],
            'technologies' => $this->technologies ? array_map(function ($technology) {
                return url("storage/{$technology}");
            }, $this->technologies) : [],
            'link_website' => $this->link_website,
            'status' => $this->status,
            'tags' => $this->tags,
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
                'slug' => $this->department->slug,
            ],
            'advantage_websites' => $this->whenLoaded('advantageWebsites', function () {
                return AdvantageWebsiteResource::collection($this->advantageWebsites);
            }),
            'review_websites' => $this->whenLoaded('reviewWebsites', function () {
                return ReviewWebsiteResource::collection($this->reviewWebsites);
            }),
            'subscriptions' => $this->whenLoaded('subscriptions', function () {
                return SubscriptionResource::collection($this->subscriptions);
            }),
            'meta' => $this->seoMeta('websites'),
        ];
    }
}
