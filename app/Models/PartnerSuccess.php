<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;



class PartnerSuccess extends Model
{
    use HasMetaSeo;
     use HasTranslations;
    protected $fillable = ['title', 'image', 'image_alt'];

     public $translatable = ['title', 'image_alt'];
}
