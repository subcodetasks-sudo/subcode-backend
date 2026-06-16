<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Sector extends Model
{
    use HasMetaSeo;
    use HasTranslations;
     protected $fillable = [
        'name',
        'image',
        'image_alt',
        'is_active',
    ];
    public $translatable = ['name', 'image_alt'];
}
