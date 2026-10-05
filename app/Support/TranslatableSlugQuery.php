<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

final class TranslatableSlugQuery
{
    /** @var list<string> */
    public const LOCALES = ['ar', 'en', 'tr'];

    public static function whereMatches(Builder $query, string $slug, ?string $locale = null, string $column = 'slug'): Builder
    {
        $slug = trim($slug);

        if ($slug === '') {
            return $query->whereRaw('1 = 0');
        }

        $locales = ($locale !== null && in_array($locale, self::LOCALES, true))
            ? [$locale]
            : self::LOCALES;

        return $query->where(function (Builder $inner) use ($column, $slug, $locales): void {
            foreach ($locales as $loc) {
                $inner->orWhere("{$column}->{$loc}", $slug);
            }
        });
    }
}
