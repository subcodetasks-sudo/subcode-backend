<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{ 
    use HasTranslations;
    protected $fillable = ['title', 'service_id'];

    public $translatable = ['title'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
