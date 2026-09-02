<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Achievement extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'image',
        'image_alt',
    ];

    public $translatable = [
        'title',
        'image_alt',
    ];

    protected static function booted(): void
    {
        static::saving(function (Achievement $achievement): void {
            if (filled($achievement->title)) {
                $achievement->image_alt = $achievement->title;
            }
        });
    }
}
