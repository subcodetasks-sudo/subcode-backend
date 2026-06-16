<?php

namespace App\Support;

final class RedirectStatusCodes
{
    /** @var list<int> */
    public const ALL = [301, 302, 307, 308, 404, 410];

    /** @var list<int> */
    public const REQUIRES_TARGET = [301, 302, 307, 308];

    public static function requiresTarget(int $statusCode): bool
    {
        return in_array($statusCode, self::REQUIRES_TARGET, true);
    }

    public static function options(): array
    {
        return [
            301 => '301 — Permanent',
            302 => '302 — Temporary',
            307 => '307 — Temporary (preserve method)',
            308 => '308 — Permanent (preserve method)',
            404 => '404 — Not Found',
            410 => '410 — Gone',
        ];
    }
}
