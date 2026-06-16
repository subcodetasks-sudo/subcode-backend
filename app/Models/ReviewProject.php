<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class ReviewProject extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'description', 'image', 'image_alt', 'project_name', 'project_image', 'project_image_alt', 'project_id'];

    public $translatable = ['name', 'description' ,'project_name', 'image_alt', 'project_image_alt'];

  

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
