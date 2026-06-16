<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SuccessNumber extends Model
{
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = [
        'title',
        'number',
        'icon',
        'is_active',
    ];

    public $translatable = ['title'];

    protected $casts = [
        'is_active' => 'boolean',
        'number' => 'integer',
    ];
}

