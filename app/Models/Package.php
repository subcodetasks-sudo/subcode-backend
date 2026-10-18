<?php

namespace App\Models;

use App\Models\Concerns\GeneratesTranslatableSlug;
use App\Models\Concerns\HasMetaSeo;
use App\Support\RedirectResourceType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use GeneratesTranslatableSlug;
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'price', 'description', 'features', 'status', 'type'];

    public $translatable = ['name', 'slug', 'description', 'features'];

    public static function redirectResourceType(): ?string
    {
        return RedirectResourceType::PACKAGE;
    }

    protected static function slugSourceAttribute(): string
    {
        return 'name';
    }

    protected function casts(): array
    {
        return [
            'features' => 'array',
        ];
    }
}
