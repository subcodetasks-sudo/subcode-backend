<?php

namespace App\Models;

use App\Models\Concerns\GeneratesTranslatableSlug;
use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use GeneratesTranslatableSlug;
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = ['title', 'slug', 'description', 'image', 'image_alt'];

    public $translatable = ['title', 'slug', 'description', 'image_alt'];

    protected static function slugSourceAttribute(): string
    {
        return 'title';
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function featureServices()
    {
        return $this->hasMany(FeatureService::class);
    }
}
