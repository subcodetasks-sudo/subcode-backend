<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->imageWithAlt($this->image, $this->image_alt),
            'features' => $this->whenLoaded('features', function () {
                return FeatureResource::collection($this->features);
            }),
            'feature_services' => $this->whenLoaded('featureServices', function () {
                return FeatureServiceResource::collection($this->featureServices);
            }),
            'meta' => $this->seoMeta('services'),
        ];
    }
}
