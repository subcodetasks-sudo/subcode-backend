<?php

namespace App\Support;

final class SlugRedirectTarget
{
    /**
     * @return array{slug: ?string, path: ?string, locale: ?string, external: bool}
     */
    public static function parse(?string $value, ?string $fallbackLocale = null): array
    {
        $raw = trim((string) $value);

        if ($raw === '') {
            return ['slug' => null, 'path' => null, 'locale' => null, 'external' => false];
        }

        if (filter_var($raw, FILTER_VALIDATE_URL)) {
            return ['slug' => null, 'path' => $raw, 'locale' => null, 'external' => true];
        }

        $path = str_starts_with($raw, '/') ? RedirectPathBuilder::normalizePath($raw) : null;
        $locale = $fallbackLocale;
        $slug = $raw;

        if ($path !== null) {
            if (preg_match('#^/(ar|en|tr)/(blogs|projects|websites|services|packages|pages)/([^/]+)/?$#i', $path, $matches)) {
                $locale = strtolower($matches[1]);
                $slug = rawurldecode($matches[3]);
            } elseif (preg_match('#^/(ar|en|tr)/([^/]+)/?$#i', $path, $matches)) {
                $locale = strtolower($matches[1]);
                $slug = rawurldecode($matches[2]);
            } else {
                $slug = trim(basename($path), '/');
            }
        }

        $slug = trim((string) $slug);

        return [
            'slug' => $slug !== '' ? $slug : null,
            'path' => $path ?? ($slug && $locale ? '/'.$locale.'/'.$slug : null),
            'locale' => $locale,
            'external' => false,
        ];
    }
}
