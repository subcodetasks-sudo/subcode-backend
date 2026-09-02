<?php

namespace App\Support;

class UploadLimits
{
    public static function maxKb(): int
    {
        return (int) config('uploads.max_kb', 1024 * 1024);
    }

    public static function maxMbLabel(): string
    {
        return (string) (int) floor(self::maxKb() / 1024);
    }
}
