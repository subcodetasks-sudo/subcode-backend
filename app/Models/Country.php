<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    public array $translatable = ['name'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
