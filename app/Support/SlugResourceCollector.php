<?php

namespace App\Support;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Occasion;
use App\Models\Package;
use App\Models\Project;
use App\Models\Service;
use App\Models\Website;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class SlugResourceCollector
{
    /**
     * @return array<string, array{model: class-string<Model>, scope?: callable}>
     */
    public static function definitions(): array
    {
        return [
            'blogs' => [
                'model' => Blog::class,
                'scope' => fn (Builder $query) => $query
                    ->where('is_active', true)
                    ->where('status', 'publish'),
            ],
            'categories' => [
                'model' => Category::class,
            ],
            'services' => [
                'model' => Service::class,
            ],
            'packages' => [
                'model' => Package::class,
                'scope' => fn (Builder $query) => $query->where('status', true),
            ],
            'occasions' => [
                'model' => Occasion::class,
                'scope' => fn (Builder $query) => $query->where('is_active', true),
            ],
            'projects' => [
                'model' => Project::class,
                'scope' => fn (Builder $query) => $query->where('status', true),
            ],
            'websites' => [
                'model' => Website::class,
            ],
            'departments' => [
                'model' => Department::class,
            ],
        ];
    }

    /**
     * @return list<string>
     */
    public function collectForLocale(string $key, string $locale): array
    {
        $definitions = self::definitions();

        if (! isset($definitions[$key])) {
            return [];
        }

        return $this->collectSlugs($definitions[$key], $locale);
    }

    /**
     * @return array<string, list<string>>
     */
    public function collectAllForLocale(string $locale): array
    {
        $slugs = [];

        foreach (self::definitions() as $key => $definition) {
            $slugs[$key] = $this->collectSlugs($definition, $locale);
        }

        return $slugs;
    }

    /**
     * @return array<string, list<array{slug: array{ar: ?string, en: ?string, tr: ?string}}>>
     */
    public function collectAllBilingual(): array
    {
        $items = [];

        foreach (self::definitions() as $key => $definition) {
            $items[$key] = $this->collectBilingualSlugs($definition);
        }

        return $items;
    }

    /**
     * @param  array{model: class-string<Model>, scope?: callable}  $definition
     * @return list<string>
     */
    private function collectSlugs(array $definition, string $locale): array
    {
        $query = $definition['model']::query()->select(['slug']);

        if (! empty($definition['scope'])) {
            $definition['scope']($query);
        }

        $slugs = [];

        foreach ($query->cursor() as $row) {
            foreach (TranslatableSlugExtractor::collect($row->slug, $locale) as $slug) {
                $slugs[] = $slug;
            }
        }

        return array_values(array_unique($slugs));
    }

    /**
     * @param  array{model: class-string<Model>, scope?: callable}  $definition
     * @return list<array{slug: array{ar: ?string, en: ?string, tr: ?string}}>
     */
    private function collectBilingualSlugs(array $definition): array
    {
        $query = $definition['model']::query()->select(['slug']);

        if (! empty($definition['scope'])) {
            $definition['scope']($query);
        }

        $items = [];

        foreach ($query->cursor() as $row) {
            $slug = TranslatableSlugExtractor::map($row->slug);

            if (($slug['ar'] ?? null) === null && ($slug['en'] ?? null) === null && ($slug['tr'] ?? null) === null) {
                continue;
            }

            $items[] = ['slug' => $slug];
        }

        return $items;
    }
}
