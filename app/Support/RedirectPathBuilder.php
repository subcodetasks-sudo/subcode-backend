<?php

namespace App\Support;

final class RedirectPathBuilder
{
    public static function sourcePath(string $resourceType, string $locale, string $slug): string
    {
        $segment = RedirectResourceType::pathSegment($resourceType);

        return self::normalizePath('/'.$locale.'/'.$segment.'/'.trim($slug));
    }

    public static function normalizePath(string $path): string
    {
        $path = rawurldecode(trim($path));

        if ($path === '') {
            return '/';
        }

        if (! str_starts_with($path, '/')) {
            $path = '/'.$path;
        }

        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }

        return $path;
    }

    public static function localeFromPath(string $path): ?string
    {
        $parts = explode('/', ltrim(self::normalizePath($path), '/'));

        if ($parts === []) {
            return null;
        }

        $locale = strtolower($parts[0]);

        return in_array($locale, ['ar', 'en', 'tr'], true) ? $locale : null;
    }
}
