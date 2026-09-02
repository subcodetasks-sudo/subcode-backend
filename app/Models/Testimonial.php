<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasMetaSeo;
    use HasTranslations;
    use SoftDeletes;
    
    protected $fillable = [
        'client_name',
        'description',
        'client_image',
        'client_image_alt',
        'project_image',
        'project_image_alt',
        'project_name',
        'is_active'
    ];

    public $translatable = ['description', 'client_image_alt', 'project_image_alt'];
    
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
