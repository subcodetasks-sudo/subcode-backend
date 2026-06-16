<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectorResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->imageWithAlt($this->image, $this->image_alt),
            'meta' => $this->seoMeta(),
        ];
    }
}
