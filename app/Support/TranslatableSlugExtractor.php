<?php

namespace App\Support;

final class TranslatableSlugExtractor
{
    /** @var list<string> */
    private const LOCALES = ['ar', 'en', 'tr'];

    /**
     * @return list<string>
     */
    public static function collect(mixed $slug, string $locale, bool $allLocales = false): array
    {
        if ($allLocales) {
            return self::allLocaleValues($slug);
        }

        $value = self::forLocale($slug, $locale);

        return $value !== null ? [$value] : [];
    }

    public static function forLocale(mixed $slug, string $locale): ?string
    {
        $locale = in_array($locale, self::LOCALES, true) ? $locale : 'ar';

        // Plain strings are ambiguous (Spatie current-locale accessors). Do not
        // treat them as valid for an arbitrary requested locale.
        if (is_string($slug)) {
            return null;
        }

        if (! is_array($slug)) {
            return null;
        }

        $value = trim((string) ($slug[$locale] ?? ''));

        return $value !== '' ? $value : null;
    }

    /**
     * @return array{ar: ?string, en: ?string, tr: ?string}
     */
    public static function map(mixed $slug): array
    {
        if (is_string($slug)) {
            // Ambiguous single value — do not clone across locales.
            return ['ar' => null, 'en' => null, 'tr' => null];
        }

        if (! is_array($slug)) {
            return ['ar' => null, 'en' => null, 'tr' => null];
        }

        $mapped = [];

        foreach (self::LOCALES as $locale) {
            $value = trim((string) ($slug[$locale] ?? ''));
            $mapped[$locale] = $value !== '' ? $value : null;
        }

        return $mapped;
    }

    /**
     * @return list<string>
     */
    public static function allLocaleValues(mixed $slug): array
    {
        $values = [];

        if (is_string($slug)) {
            return [];
        }

        if (! is_array($slug)) {
            return [];
        }

        foreach (self::LOCALES as $locale) {
            $value = trim((string) ($slug[$locale] ?? ''));
            if ($value !== '') {
                $values[] = $value;
            }
        }

        return array_values(array_unique($values));
    }
}
