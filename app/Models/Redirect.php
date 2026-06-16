<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Redirect extends Model
{
    public const TYPE_BLOG = 'blog';

    public const TYPE_PROJECT = 'project';

    public const TYPE_WEBSITE = 'website';

    public const TYPE_SERVICE = 'service';

    public const TYPE_PACKAGE = 'package';

    public const TYPE_PAGE = 'page';

    public const TYPE_OTHER = 'other';

    protected $fillable = [
        'resource_type',
        'resource_id',
        'source_locale',
        'source_slug',
        'source_path',
        'status_code',
        'target_slug',
        'target_path',
        'target_locale',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'status_code' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
