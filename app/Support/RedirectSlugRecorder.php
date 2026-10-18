<?php

namespace App\Support;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Model;

/**
 * Records a 301 in the redirects table whenever a translated slug is edited,
 * so the old public URL keeps working.
 */
final class RedirectSlugRecorder
{
    public static function record(Model $model): void
    {
        $type = $model::redirectResourceType();

        if ($type === null || ! $model->wasChanged('slug')) {
            return;
        }

        $old = json_decode((string) $model->getOriginal('slug'), true) ?: [];
        $new = $model->getTranslations('slug');

        foreach (['ar', 'en', 'tr'] as $locale) {
            $oldSlug = trim((string) ($old[$locale] ?? ''));
            $newSlug = trim((string) ($new[$locale] ?? ''));

            if ($oldSlug === '' || $newSlug === '' || $oldSlug === $newSlug) {
                continue;
            }

            self::redirect($type, $model->getKey(), $locale, $oldSlug, $newSlug);
        }
    }

    private static function redirect(string $type, mixed $id, string $locale, string $oldSlug, string $newSlug): void
    {
        $oldPath = RedirectPathBuilder::sourcePath($type, $locale, $oldSlug);
        $newPath = RedirectPathBuilder::sourcePath($type, $locale, $newSlug);

        // Moving back to a previous slug must not leave a loop behind.
        Redirect::query()
            ->where('source_locale', $locale)
            ->where('source_path', $newPath)
            ->delete();

        // Flatten chains: anything that pointed at the old URL now points at the new one.
        Redirect::query()
            ->where('target_locale', $locale)
            ->where('target_path', $oldPath)
            ->update(['target_path' => $newPath, 'target_slug' => $newSlug]);

        Redirect::updateOrCreate(
            ['source_locale' => $locale, 'source_path' => $oldPath],
            [
                'resource_type' => $type,
                'resource_id' => $id,
                'status_code' => 301,
                'target_path' => $newPath,
                'is_active' => true,
            ],
        );
    }
}
