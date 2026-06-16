<?php

namespace App\Models;

use App\Models\Concerns\GeneratesTranslatableSlug;
use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use GeneratesTranslatableSlug;
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'description', 'image', 'link_project', 'department_id', 'status', 'caption', 'main_image', 'main_image_alt', 'images', 'tags', 'long_description', 'technologies', 'is_special'];

    public $translatable = ['name', 'description', 'caption', 'long_description', 'slug', 'tags', 'main_image_alt'];

    protected static function slugSourceAttribute(): string
    {
        return 'name';
    }

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

    public function advantageProjects()
    {
        return $this->hasMany(AdvantageProject::class);
    }

    public function reviewProjects()
    {
        return $this->hasMany(ReviewProject::class);
    }
}
