<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FQ extends Model
{
    use HasMetaSeo;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['question', 'answer'];

    protected $fillable=[
        'question','answer' 
    ];
}
