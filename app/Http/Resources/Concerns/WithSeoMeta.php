<?php

namespace App\Http\Resources\Concerns;

use App\Services\SocialMetaResolver;

trait WithSeoMeta
{
    protected function seoMeta(?string $pageKey = null, ?string $canonicalUrl = null): array
    {
        $locale = request()->header('Accept-Language', app()->getLocale());

        $meta = [
            'meta_title' => $this->meta?->meta_title,
            'meta_description' => $this->meta?->meta_description,
        ];

        if ($pageKey) {
            $meta['social'] = app(SocialMetaResolver::class)->resolve(
                $pageKey,
                $this->resource,
                $canonicalUrl,
                $locale,
            );
        }

        return $meta;
    }

    protected function imageWithAlt(?string $path, mixed $alt = null): ?array
    {
        if (! $path) {
            return null;
        }

        return [
            'url' => url("storage/{$path}"),
            'alt' => $alt,
        ];
    }
}
