<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SeoSettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'page_key' => $this->page_key,
            'page_name' => $this->page_name,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'social' => [
                'open_graph' => array_filter([
                    'title' => $this->og_title,
                    'description' => $this->og_description,
                    'image' => $this->og_image ? Storage::disk('public')->url($this->og_image) : null,
                    'type' => $this->og_type,
                ], fn ($value) => $value !== null && $value !== ''),
                'twitter' => array_filter([
                    'card' => $this->twitter_card,
                    'title' => $this->twitter_title,
                    'description' => $this->twitter_description,
                    'image' => $this->twitter_image ? Storage::disk('public')->url($this->twitter_image) : null,
                ], fn ($value) => $value !== null && $value !== ''),
            ],
        ];
    }
}
