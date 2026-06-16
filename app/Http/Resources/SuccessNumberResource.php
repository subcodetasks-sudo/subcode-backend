<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessNumberResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'number' => $this->number,
            'icon' => $this->icon ? url("storage/{$this->icon}") : null,
            'meta' => $this->seoMeta(),
            'is_active' => $this->is_active,
        ];
    }
}
