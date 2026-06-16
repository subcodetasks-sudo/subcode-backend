<?php

namespace App\Support;

final class SocialContentType
{
    public const HOME = 'home';

    public const BLOG = 'blog';

    public const BLOGS = 'blogs';

    public const SERVICE = 'service';

    public const SERVICES = 'services';

    public const PACKAGE = 'package';

    public const PACKAGES = 'packages';

    public const PROJECT = 'project';

    public const PROJECTS = 'projects';

    public const WEBSITE = 'website';

    public const WEBSITES = 'websites';

    public const DEFAULT_OG_TYPES = [
        self::BLOG => 'article',
        self::BLOGS => 'article',
        self::SERVICE => 'website',
        self::SERVICES => 'website',
        self::PACKAGE => 'website',
        self::PACKAGES => 'website',
        self::PROJECT => 'website',
        self::PROJECTS => 'website',
        self::WEBSITE => 'website',
        self::WEBSITES => 'website',
        self::HOME => 'website',
    ];
}
