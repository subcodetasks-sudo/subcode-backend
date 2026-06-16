<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class FeatureService extends Model
{
 use HasTranslations;

    protected $fillable = ['title', 'description', 'image', 'image_alt', 'service_id'];

    public $translatable = ['title', 'description', 'image_alt'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
