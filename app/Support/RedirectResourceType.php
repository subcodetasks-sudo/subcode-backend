<?php

namespace App\Support;

final class RedirectResourceType
{
    public const BLOG = 'blog';

    public const PROJECT = 'project';

    public const WEBSITE = 'website';

    public const SERVICE = 'service';

    public const PACKAGE = 'package';

    public const PAGE = 'page';

    public const OTHER = 'other';

    /** @var list<string> */
    public const ALL = [
        self::BLOG,
        self::PROJECT,
        self::WEBSITE,
        self::SERVICE,
        self::PACKAGE,
        self::PAGE,
        self::OTHER,
    ];

    public static function options(): array
    {
        return [
            self::BLOG => __('admin.redirect_type_blog'),
            self::PROJECT => __('admin.redirect_type_project'),
            self::WEBSITE => __('admin.redirect_type_website'),
            self::SERVICE => __('admin.redirect_type_service'),
            self::PACKAGE => __('admin.redirect_type_package'),
            self::PAGE => __('admin.redirect_type_page'),
            self::OTHER => __('admin.redirect_type_other'),
        ];
    }

    public static function pathSegment(string $resourceType): string
    {
        return match ($resourceType) {
            self::BLOG => 'blogs',
            self::PROJECT => 'projects',
            self::WEBSITE => 'websites',
            self::SERVICE => 'services',
            self::PACKAGE => 'packages',
            self::PAGE => 'pages',
            default => 'pages',
        };
    }

    public static function inferFromPath(string $path): ?string
    {
        $path = strtolower(RedirectPathBuilder::normalizePath($path));

        return match (true) {
            str_contains($path, '/blogs/') => self::BLOG,
            str_contains($path, '/projects/') => self::PROJECT,
            str_contains($path, '/websites/') => self::WEBSITE,
            str_contains($path, '/services/') => self::SERVICE,
            str_contains($path, '/packages/') => self::PACKAGE,
            default => null,
        };
    }
}
