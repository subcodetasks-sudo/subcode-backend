<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WebsiteSubscriber extends Model
{
    use HasTranslations;

    protected $fillable = ['website_id', 'name', 'opinion', 'image', 'image_alt'];

    public array $translatable = ['name', 'opinion', 'image_alt'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
