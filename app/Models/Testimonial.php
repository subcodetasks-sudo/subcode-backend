<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'media',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function isVideoPath(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return in_array(
            strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            ['mp4', 'webm', 'mov', 'avi', 'mkv', 'ogv', 'ogg'],
            true,
        );
    }
}
