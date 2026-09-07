<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * Fills the SEO `meta` (meta_title / meta_description) for services and projects
 * that currently return empty meta, plus the home meta on settings.
 *
 * Source data: database/data/seo-meta.json.
 * Idempotent: re-running only overwrites the locales present in the JSON and
 * never touches social_meta / og_* fields on the Meta row.
 */
class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/seo-meta.json');

        if (! File::exists($path)) {
            $this->command?->warn("SeoMetaSeeder: {$path} not found, skipping.");

            return;
        }

        $data = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        foreach ($data['services'] ?? [] as $row) {
            $service = Service::find($row['id']);

            if (! $service) {
                $this->command?->warn("SeoMetaSeeder: service #{$row['id']} not found, skipping.");

                continue;
            }

            $this->writeMeta($service, $row['meta']);
        }

        foreach ($data['projects'] ?? [] as $row) {
            $project = $this->findProject($row);

            if (! $project) {
                $this->command?->warn("SeoMetaSeeder: project #{$row['id']} ({$row['slug']}) not found, skipping.");

                continue;
            }

            $this->writeMeta($project, $row['meta']);
        }

        $this->writeSettings($data['settings'] ?? []);

        $this->command?->info('SeoMetaSeeder: done.');
    }

    private function findProject(array $row): ?Project
    {
        if (! empty($row['id']) && ($project = Project::find($row['id']))) {
            return $project;
        }

        if (empty($row['slug'])) {
            return null;
        }

        return Project::query()
            ->where('slug->ar', $row['slug'])
            ->orWhere('slug->en', $row['slug'])
            ->orWhere('slug->tr', $row['slug'])
            ->first();
    }

    /**
     * @param  \App\Models\Concerns\HasMetaSeo|\Illuminate\Database\Eloquent\Model  $model
     * @param  array<string, array{meta_title?: string, meta_description?: string}>  $translations
     */
    private function writeMeta($model, array $translations): void
    {
        $meta = $model->meta()->firstOrNew([]);

        $title = $meta->getTranslations('meta_title');
        $description = $meta->getTranslations('meta_description');

        foreach ($translations as $locale => $values) {
            if (! empty($values['meta_title'])) {
                $title[$locale] = $values['meta_title'];
            }

            if (! empty($values['meta_description'])) {
                $description[$locale] = $values['meta_description'];
            }
        }

        $meta->setTranslations('meta_title', $title);
        $meta->setTranslations('meta_description', $description);
        $model->meta()->save($meta);
    }

    private function writeSettings(array $settings): void
    {
        if ($settings === []) {
            return;
        }

        $setting = Setting::query()->first();

        if (! $setting) {
            $this->command?->warn('SeoMetaSeeder: no settings row, skipping settings.');

            return;
        }

        foreach (['home_meta_title', 'home_meta_description'] as $key) {
            if (! empty($settings[$key]) && is_array($settings[$key])) {
                $setting->setTranslations($key, array_filter($settings[$key]));
            }
        }

        // Images (og_default_image etc.) are intentionally left untouched.

        $setting->save();
    }
}
