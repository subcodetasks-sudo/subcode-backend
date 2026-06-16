<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class TeamMember extends Model
{
    use HasMetaSeo;
    use HasTranslations;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'specialty',
        'image',
        'image_alt',
        'is_active',
    ];

    public array $translatable = ['image_alt'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

