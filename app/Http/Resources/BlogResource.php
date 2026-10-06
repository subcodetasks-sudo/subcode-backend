<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BlogResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        $publishedAt = $this->resolvePublishedAt();
        $updatedAt = $this->resolveUpdatedAt($publishedAt);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => $this->imageWithAlt($this->image, $this->image_alt),
            'status' => $this->status,
            'time_publish' => $this->time_publish,
            'is_active' => $this->is_active,
            'meta' => $this->seoMeta('blogs'),
            'category' => $this->when($this->category, fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
                'image' => $this->imageWithAlt($this->category->image, $this->category->image_alt),
            ]),
            'author' => [
                'name' => 'Seo Team',
            ],
            'published_at' => $this->toIso8601Utc($publishedAt),
            'updated_at' => $this->toIso8601Utc($updatedAt),
            'created_at' => $this->toIso8601Utc($this->created_at),
        ];
    }

    protected function resolvePublishedAt(): CarbonInterface
    {
        if ($this->time_publish) {
            return Carbon::parse($this->time_publish);
        }

        return Carbon::parse($this->created_at);
    }

    protected function resolveUpdatedAt(CarbonInterface $publishedAt): CarbonInterface
    {
        $updatedAt = $this->updated_at
            ? Carbon::parse($this->updated_at)
            : $publishedAt->copy();

        return $updatedAt->lt($publishedAt) ? $publishedAt->copy() : $updatedAt;
    }

    protected function toIso8601Utc(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value)->utc()->format('Y-m-d\TH:i:s.u\Z');
    }
}
