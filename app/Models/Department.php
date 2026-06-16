<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = ['name', 'slug'];

    
    public array $translatable = ['name' , 'slug'];

      protected static function boot()
{
    parent::boot();
    
    static::saving(function ($model) {
        $langs = config('translatable.locales', ['en', 'ar' , 'tr']);
        $slugs = [];
        
        foreach ($langs as $lang) {
            $name = $model->getTranslation('name', $lang);
            if ($name) {
                $slug = self::generateSlug($name, $lang, $model->id);
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
        $slug .= $separator . rand(1, 100);
    }
    
    return $slug;
}


    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function websites()
    {
        return $this->hasMany(Website::class);
    }
}
