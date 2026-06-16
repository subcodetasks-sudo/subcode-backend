<?php

namespace App\Models;

use App\Models\Concerns\GeneratesTranslatableSlug;
use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use GeneratesTranslatableSlug;
    use HasMetaSeo;
    use HasTranslations;
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'slug', 'auther_id', 'image', 'image_alt', 'status', 'time_publish', 'is_active', 'category_id',
    ];

    public array $translatable = ['title', 'description', 'slug', 'image_alt'];

    protected static function slugSourceAttribute(): string
    {
        return 'title';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'auther_id');
    }
}
