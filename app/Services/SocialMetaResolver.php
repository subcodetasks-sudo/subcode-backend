<?php

namespace App\Services;

use App\Models\Meta;
use App\Models\SeoSetting;
use App\Models\Setting;
use App\Support\SocialContentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SocialMetaResolver
{
    public function resolve(string $contentType, Model $entity, ?string $canonicalUrl = null, ?string $locale = null): array
    {
        $locale = $this->normalizeLocale($locale);
        $settings = Setting::query()->first();
        $template = SeoSetting::query()->where('page_key', $contentType)->first();
        $meta = $this->entityMeta($entity);

        $title = $this->pick(
            $locale,
            $meta?->og_title,
            $template?->og_title,
            $meta?->meta_title,
            $entity->title ?? null,
            $entity->name ?? null,
            $settings?->home_meta_title,
            $settings?->meta_title,
            $settings?->site_name,
        );

        $description = $this->pick(
            $locale,
            $meta?->og_description,
            $template?->og_description,
            $meta?->meta_description,
            $entity->description ?? null,
            $settings?->home_meta_description,
            $settings?->meta_description,
            $settings?->site_description,
        );

        $imagePath = $this->pick(
            $locale,
            $meta?->og_image,
            $meta?->twitter_image,
            $this->entityImage($entity, $locale),
            $template?->og_image,
            $template?->twitter_image,
            $settings?->og_default_image,
            $settings?->site_logo,
        );

        $image = $this->toAbsoluteUrl($imagePath);

        $twitterTitle = $this->pick(
            $locale,
            $meta?->twitter_title,
            $template?->twitter_title,
            $meta?->og_title,
            $template?->og_title,
            $meta?->meta_title,
            $entity->title ?? null,
            $entity->name ?? null,
            $settings?->home_meta_title,
            $settings?->meta_title,
            $settings?->site_name,
        );

        $twitterDescription = $this->pick(
            $locale,
            $meta?->twitter_description,
            $template?->twitter_description,
            $meta?->og_description,
            $template?->og_description,
            $meta?->meta_description,
            $entity->description ?? null,
            $settings?->home_meta_description,
            $settings?->meta_description,
            $settings?->site_description,
        );

        $twitterImagePath = $this->pick(
            $locale,
            $meta?->twitter_image,
            $meta?->og_image,
            $this->entityImage($entity, $locale),
            $template?->twitter_image,
            $template?->og_image,
            $settings?->og_default_image,
            $settings?->site_logo,
        );

        $twitterImage = $this->toAbsoluteUrl($twitterImagePath);

        $twitterCard = $meta?->twitter_card
            ?? $template?->twitter_card
            ?? $settings?->twitter_card_default
            ?? 'summary_large_image';

        $ogType = $meta?->og_type
            ?? $template?->og_type
            ?? SocialContentType::DEFAULT_OG_TYPES[$contentType]
            ?? 'website';

        return [
            'open_graph' => array_filter([
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'url' => $canonicalUrl ?? $entity->canonical_url ?? null,
                'type' => $ogType,
                'site_name' => $this->pick($locale, $settings?->site_name),
            ], fn ($value) => $value !== null && $value !== ''),
            'twitter' => array_filter([
                'card' => $twitterCard,
                'site' => $settings?->twitter_site,
                'title' => $twitterTitle,
                'description' => $twitterDescription,
                'image' => $twitterImage,
            ], fn ($value) => $value !== null && $value !== ''),
            'facebook' => array_filter([
                'app_id' => $settings?->facebook_app_id,
            ], fn ($value) => $value !== null && $value !== ''),
        ];
    }

    public function resolvePage(string $pageKey, ?string $locale = null): array
    {
        $locale = $this->normalizeLocale($locale);
        $settings = Setting::query()->first();
        $template = SeoSetting::query()->where('page_key', $pageKey)->first();

        $title = $this->pick(
            $locale,
            $template?->og_title,
            $template?->meta_title,
            $settings?->home_meta_title,
            $settings?->meta_title,
            $settings?->site_name,
        );

        $description = $this->pick(
            $locale,
            $template?->og_description,
            $template?->meta_description,
            $settings?->home_meta_description,
            $settings?->meta_description,
            $settings?->site_description,
        );

        $imagePath = $this->pick(
            $locale,
            $template?->og_image,
            $template?->twitter_image,
            $settings?->og_default_image,
            $settings?->site_logo,
        );

        $image = $this->toAbsoluteUrl($imagePath);

        $twitterTitle = $this->pick(
            $locale,
            $template?->twitter_title,
            $template?->og_title,
            $template?->meta_title,
            $settings?->home_meta_title,
            $settings?->meta_title,
            $settings?->site_name,
        );

        $twitterDescription = $this->pick(
            $locale,
            $template?->twitter_description,
            $template?->og_description,
            $template?->meta_description,
            $settings?->home_meta_description,
            $settings?->meta_description,
            $settings?->site_description,
        );

        $twitterImagePath = $this->pick(
            $locale,
            $template?->twitter_image,
            $template?->og_image,
            $settings?->og_default_image,
            $settings?->site_logo,
        );

        $twitterImage = $this->toAbsoluteUrl($twitterImagePath);

        $twitterCard = $template?->twitter_card
            ?? $settings?->twitter_card_default
            ?? 'summary_large_image';

        $ogType = $template?->og_type
            ?? SocialContentType::DEFAULT_OG_TYPES[$pageKey]
            ?? 'website';

        return [
            'meta_title' => $this->pick($locale, $template?->meta_title, $settings?->home_meta_title, $settings?->meta_title),
            'meta_description' => $this->pick($locale, $template?->meta_description, $settings?->home_meta_description, $settings?->meta_description),
            'social' => [
                'open_graph' => array_filter([
                    'title' => $title,
                    'description' => $description,
                    'image' => $image,
                    'type' => $ogType,
                    'site_name' => $this->pick($locale, $settings?->site_name),
                ], fn ($value) => $value !== null && $value !== ''),
                'twitter' => array_filter([
                    'card' => $twitterCard,
                    'site' => $settings?->twitter_site,
                    'title' => $twitterTitle,
                    'description' => $twitterDescription,
                    'image' => $twitterImage,
                ], fn ($value) => $value !== null && $value !== ''),
                'facebook' => array_filter([
                    'app_id' => $settings?->facebook_app_id,
                ], fn ($value) => $value !== null && $value !== ''),
            ],
        ];
    }

    private function entityMeta(Model $entity): ?Meta
    {
        if (! method_exists($entity, 'meta')) {
            return null;
        }

        return $entity->relationLoaded('meta') ? $entity->meta : $entity->meta()->first();
    }

    private function entityImage(Model $entity, string $locale): ?string
    {
        $localizedKey = "image_{$locale}";

        if (! empty($entity->{$localizedKey})) {
            return $entity->{$localizedKey};
        }

        return $entity->main_image ?? $entity->image ?? $entity->image_ar ?? null;
    }

    private function normalizeLocale(?string $locale): string
    {
        $locale = $locale ?? app()->getLocale();

        return in_array($locale, ['ar', 'en', 'tr'], true) ? $locale : 'ar';
    }

    private function pick(string $locale, mixed ...$candidates): ?string
    {
        foreach ($candidates as $candidate) {
            if ($candidate === null || $candidate === '') {
                continue;
            }

            if (is_array($candidate)) {
                $value = $candidate[$locale]
                    ?? $candidate['ar']
                    ?? $candidate['en']
                    ?? $candidate['tr']
                    ?? (count($candidate) ? (string) reset($candidate) : null);

                if ($value !== null && $value !== '') {
                    return $value;
                }

                continue;
            }

            return (string) $candidate;
        }

        return null;
    }

    private function toAbsoluteUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url(ltrim($path, '/'));
    }
}
