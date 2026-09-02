<?php

namespace App\Http\Resources;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'media' => $this->mediaPayload(),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    protected function mediaPayload(): ?array
    {
        if (! $this->media) {
            return null;
        }

        return [
            'url' => url("storage/{$this->media}"),
            'type' => Testimonial::isVideoPath($this->media) ? 'video' : 'image',
        ];
    }
}
