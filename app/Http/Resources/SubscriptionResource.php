<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'features' => $this->features,
            'price' => $this->price,
            'status' => $this->status,
            'type' => $this->type,
            'type_name' => $this->type === 'monthly' ? __('strings.monthly') : ($this->type === 'yearly' ? __('strings.yearly') : $this->type),
        ];
    }
}

