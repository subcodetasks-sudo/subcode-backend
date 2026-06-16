<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_ar' => $this->imageWithAlt($this->image_ar, $this->image_alt_ar),
            'image_en' => $this->imageWithAlt($this->image_en, $this->image_alt_en),
            'image_tr' => $this->imageWithAlt($this->image_tr, $this->image_alt_tr),
            'meta' => $this->seoMeta('about'),
        ];
    }
}
