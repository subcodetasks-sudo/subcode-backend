<?php

namespace App\Models;

use App\Models\Concerns\HasMetaSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FeaturePackage extends Model
{
    use HasMetaSeo;
    use HasTranslations;

    protected $fillable = ['name', 'package_id'];

    public $translatable = ['name'];

    protected $casts = [
    'package_id' => 'array',
];

    protected function casts(): array
    {
        return [
            'package_id' => 'array',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
