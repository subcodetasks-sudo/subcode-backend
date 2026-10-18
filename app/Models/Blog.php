<?php

namespace App\Models;

use App\Models\Concerns\GeneratesTranslatableSlug;
use App\Models\Concerns\HasMetaSeo;
use App\Support\RedirectResourceType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use GeneratesTranslatableSlug;
    use HasMetaSeo;
    use HasTranslations;
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'slug', 'auther_id', 'image', 'image_alt', 'status', 'time_publish', 'is_active', 'category_id',
    ];

    public array $translatable = ['title', 'description', 'slug', 'image_alt'];

    protected function casts(): array
    {
        return [
            'time_publish' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    protected static function slugSourceAttribute(): string
    {
        return 'title';
    }

    public static function redirectResourceType(): ?string
    {
        return RedirectResourceType::BLOG;
    }

    /**
     * Visible on the site: published, or scheduled with its publish time already reached.
     */
    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->where('is_active', 1)->where(function (Builder $q): void {
            $q->where('status', 'publish')
                ->orWhere(fn (Builder $s) => $s->where('status', 'schedule')->where('time_publish', '<=', now()));
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'auther_id');
    }
}
