<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class AdvantageProject extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'project_id'];

    public $translatable = ['title', 'description'];

  

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
