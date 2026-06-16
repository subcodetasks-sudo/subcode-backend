<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Website extends Model
{
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'link_website',
        'department_id',
        'status',
        'caption',
        'main_image',
        'main_image_alt',
        'images',
        'tags',
        'long_description',
        'technologies',
        'is_special',
    ];

    public $translatable = [
        'name',
        'description',
        'caption',
        'long_description',
        'slug',
        'tags',
        'main_image_alt',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'technologies' => 'array',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function advantageWebsites()
    {
        return $this->hasMany(AdvantageWebsite::class);
    }

    public function reviewWebsites()
    {
        return $this->hasMany(ReviewWebsite::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function visitors()
    {
        return $this->morphMany(Visitor::class, 'visitable');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $langs = config('translatable.locales', ['en', 'ar' ,'tr']);
            $slugs = [];

            foreach ($langs as $lang) {
                $title = $model->getTranslation('name', $lang);
                if ($title) {
                    $slug = self::generateSlug($title, $lang, $model->id);
                    $slugs[$lang] = $slug;
                }
            }

            $model->setTranslations('slug', $slugs);
        });
    }

    // Fixed generateSlug method
    public static function generateSlug($string, $lang, $excludeId = null, $separator = '-')
    {
        if (is_null($string)) {
            return '';
        }

        $slug = trim($string);
        $slug = mb_strtolower($slug, 'UTF-8');
        $slug = str_replace(['/', '\\'], $separator, $slug);
        $slug = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", '', $slug);
        $slug = preg_replace("/[\s-]+/", ' ', $slug);
        $slug = preg_replace("/[\s_]/", $separator, $slug);

        // Fixed: Use whereRaw with JSON_EXTRACT to handle null values properly
        $query = self::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.\"$lang\"')) = ?", [$slug]);

        // Exclude current model when updating
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $existingSlug = $query->first();

        if ($existingSlug) {
            $slug .= $separator.rand(1, 100);
        }

        return $slug;
    }
}

