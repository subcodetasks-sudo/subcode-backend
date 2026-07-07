<?php

namespace App\Models\Concerns;

trait GeneratesTranslatableSlug
{
    protected static function bootGeneratesTranslatableSlug(): void
    {
        static::saving(function ($model): void {
            $model->syncTranslatableSlugs();
        });
    }

    protected static function slugSourceAttribute(): string
    {
        return 'title';
    }

    public function syncTranslatableSlugs(): void
    {
        $langs = config('translatable.locales', ['ar', 'en', 'tr']);
        $slugs = $this->getTranslations('slug');

        foreach ($langs as $lang) {
            $existing = trim((string) ($slugs[$lang] ?? ''));
            if ($existing !== '') {
                continue;
            }

            $source = $this->getTranslation(static::slugSourceAttribute(), $lang);
            if ($source) {
                $slugs[$lang] = static::generateSlug($source, $lang, $this->id);
            }
        }

        if ($slugs !== []) {
            $this->setTranslations('slug', $slugs);
        }
    }

    public static function generateSlug(?string $string, string $lang, ?int $excludeId = null, string $separator = '-'): string
    {
        if ($string === null || trim($string) === '') {
            return '';
        }

        $slug = trim($string);
        $slug = mb_strtolower($slug, 'UTF-8');
        $slug = str_replace(['/', '\\'], $separator, $slug);
        $slug = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", '', $slug);
        $slug = preg_replace("/[\s-]+/", ' ', $slug);
        $slug = preg_replace("/[\s_]/", $separator, $slug);

        $query = static::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.\"$lang\"')) = ?", [$slug]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            $slug .= $separator.rand(1, 100);
        }

        return $slug;
    }

    public function scopeWhereSlug($query, string $slug, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $query->where("slug->{$locale}", $slug);
    }

    public function scopeFindBySlugOrId($query, string|int $slugOrId, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        if (is_numeric($slugOrId)) {
            return $query->find((int) $slugOrId);
        }

        return $query->whereSlug((string) $slugOrId, $locale)->first();
    }

    public static function findBySlugOrId(string|int $slugOrId, ?string $locale = null): ?static
    {
        return static::query()->findBySlugOrId($slugOrId, $locale);
    }
}
