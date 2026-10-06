<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceFaq extends Model
{
    use HasTranslations;

    protected $fillable = [
        'service_id',
        'question',
        'answer',
        'sort_order',
    ];

    public array $translatable = ['question', 'answer'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
