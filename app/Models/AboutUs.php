<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AboutUs extends Model
{
    use HasMetaSeo;
    use HasTranslations;
    protected $fillable = ['title', 'description', 'image_ar', 'image_en', 'image_tr', 'image_alt'];
    public $translatable = ['title', 'description', 'image_alt'];
}
