<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class SeoSetting extends Model
{
    use HasTranslations;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('seo_settings.all'));
    }

    protected $fillable = [
        'page_key',
        'page_name',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
    ];

    public array $translatable = [
        'page_name',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'twitter_title',
        'twitter_description',
    ];
}
