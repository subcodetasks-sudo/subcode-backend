<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Subscription extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'price',
        'description',
        'features',
        'status',
        'type',
        'website_id'
    ];

    public $translatable = ['name', 'description', 'features'];

    protected function casts(): array
    {
        return [
            'features' => 'array',
        ];
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}

