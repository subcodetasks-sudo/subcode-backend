<?php

namespace App\Models\Concerns;

use App\Support\TranslatableSlugQuery;

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
        $langs = config('translatable.locales', TranslatableSlugQuery::LOCALES);
        $slugs = $this->getTranslations('slug');
        $changed = false;

        foreach ($langs as $lang) {
            $existing = trim((string) ($slugs[$lang] ?? ''));

            if ($existing !== '') {
                if (($slugs[$lang] ?? null) !== $existing) {
                    $slugs[$lang] = $existing;
                    $changed = true;
                }

                continue;
            }

            $source = $this->getTranslation(static::slugSourceAttribute(), $lang, false);
            if ($source) {
                $slugs[$lang] = static::generateSlug($source, $lang, $this->id);
                $changed = true;
            }
        }

        if ($changed || $slugs !== []) {
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
        $slug = trim($slug, $separator.' ');

        if ($slug === '') {
            return '';
        }

        $query = static::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.\"$lang\"')) = ?", [$slug]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            $slug .= $separator.rand(1, 100);
        }

        return $slug;
    }

    /**
     * Match a slug in one locale, or any locale when $locale is null.
     */
    public function scopeWhereSlug($query, string $slug, ?string $locale = null)
    {
        return TranslatableSlugQuery::whereMatches($query, $slug, $locale);
    }

    /**
     * Constrain by numeric id or by slug in any locale. Always returns the query builder.
     */
    public function scopeWhereSlugOrId($query, string|int $slugOrId, ?string $locale = null)
    {
        if (is_numeric($slugOrId)) {
            return $query->whereKey((int) $slugOrId);
        }

        return $query->whereSlug(trim((string) $slugOrId), $locale);
    }

    public static function findBySlugOrId(string|int $slugOrId, ?string $locale = null): ?static
    {
        return static::query()->whereSlugOrId($slugOrId, $locale)->first();
    }
}
