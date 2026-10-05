<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var list<string> */
    private array $tables = [
        'blogs',
        'projects',
        'services',
        'packages',
        'occasions',
        'websites',
        'categories',
        'departments',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'slug')) {
                continue;
            }

            DB::table($table)->orderBy('id')->chunkById(100, function ($rows) use ($table): void {
                foreach ($rows as $row) {
                    $decoded = json_decode((string) $row->slug, true);

                    if (! is_array($decoded)) {
                        continue;
                    }

                    $trimmed = [];
                    $changed = false;

                    foreach ($decoded as $locale => $value) {
                        if (! is_string($value)) {
                            $trimmed[$locale] = $value;

                            continue;
                        }

                        $clean = trim($value);
                        $trimmed[$locale] = $clean;

                        if ($clean !== $value) {
                            $changed = true;
                        }
                    }

                    if (! $changed) {
                        continue;
                    }

                    DB::table($table)->where('id', $row->id)->update([
                        'slug' => json_encode($trimmed, JSON_UNESCAPED_UNICODE),
                    ]);
                }
            });
        }

        Cache::forget('slugs.all_locales');
        Cache::forget('slugs.v2.all_locales');
        foreach (['ar', 'en', 'tr'] as $locale) {
            Cache::forget("slugs.{$locale}");
            Cache::forget("slugs.v2.{$locale}");
        }
    }

    public function down(): void
    {
        // Irreversible data cleanup.
    }
};
