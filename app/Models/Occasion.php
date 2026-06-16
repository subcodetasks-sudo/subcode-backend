<?php

namespace App\Models;

use App\Models\Concerns\GeneratesTranslatableSlug;
use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Occasion extends Model
{
    use GeneratesTranslatableSlug;
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'image_alt',
        'is_active',
    ];

    public $translatable = ['name', 'slug', 'image_alt'];

    protected static function slugSourceAttribute(): string
    {
        return 'name';
    }
}
