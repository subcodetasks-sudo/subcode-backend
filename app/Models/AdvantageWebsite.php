<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AdvantageWebsite extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'website_id'];

    public $translatable = ['title', 'description'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}

