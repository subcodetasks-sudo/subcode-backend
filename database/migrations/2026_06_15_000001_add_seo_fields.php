<?php

use App\Models\Blog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->text('page_name')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->text('meta_title')->nullable()->after('meta_keywords');
            $table->text('home_meta_title')->nullable()->after('meta_description');
            $table->text('home_meta_description')->nullable()->after('home_meta_title');
            $table->text('site_logo_alt')->nullable()->after('site_favicon');
            $table->text('site_favicon_alt')->nullable()->after('site_logo_alt');
            $table->text('profile_one_alt')->nullable()->after('profile_two');
            $table->text('profile_two_alt')->nullable()->after('profile_one_alt');
        });

        $imageAltTables = [
            'projects' => ['main_image_alt'],
            'websites' => ['main_image_alt'],
            'blogs' => ['image_alt'],
            'categories' => ['image_alt'],
            'services' => ['image_alt'],
            'feature_services' => ['image_alt'],
            'partner_successes' => ['image_alt'],
            'occasions' => ['image_alt'],
            'sectors' => ['image_alt'],
            'team_members' => ['image_alt'],
            'testimonials' => ['client_image_alt', 'project_image_alt'],
            'review_projects' => ['image_alt', 'project_image_alt'],
            'review_websites' => ['image_alt', 'project_image_alt'],
        ];

        foreach ($imageAltTables as $table => $columns) {
            Schema::table($table, function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    $table->text($column)->nullable();
                }
            });
        }

        Schema::table('about_us', function (Blueprint $table) {
            $table->text('image_alt')->nullable()->after('image_tr');
        });

        Blog::query()
            ->where(function ($query) {
                $query->whereNotNull('meta_title')
                    ->orWhereNotNull('meta_description');
            })
            ->each(function (Blog $blog) {
                $locales = config('translatable.locales', ['ar', 'en', 'tr']);
                $metaTitle = [];
                $metaDescription = [];

                foreach ($locales as $locale) {
                    if ($blog->getRawOriginal('meta_title')) {
                        $metaTitle[$locale] = $blog->getRawOriginal('meta_title');
                    }
                    if ($blog->getRawOriginal('meta_description')) {
                        $metaDescription[$locale] = $blog->getRawOriginal('meta_description');
                    }
                }

                if ($metaTitle !== [] || $metaDescription !== []) {
                    $blog->meta()->updateOrCreate([], [
                        'meta_title' => $metaTitle !== [] ? $metaTitle : null,
                        'meta_description' => $metaDescription !== [] ? $metaDescription : null,
                    ]);
                }
            });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });

        $imageAltTables = [
            'projects' => ['main_image_alt'],
            'websites' => ['main_image_alt'],
            'blogs' => ['image_alt'],
            'categories' => ['image_alt'],
            'services' => ['image_alt'],
            'feature_services' => ['image_alt'],
            'partner_successes' => ['image_alt'],
            'occasions' => ['image_alt'],
            'sectors' => ['image_alt'],
            'team_members' => ['image_alt'],
            'testimonials' => ['client_image_alt', 'project_image_alt'],
            'review_projects' => ['image_alt', 'project_image_alt'],
            'review_websites' => ['image_alt', 'project_image_alt'],
        ];

        foreach ($imageAltTables as $table => $columns) {
            Schema::table($table, function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'home_meta_title',
                'home_meta_description',
                'site_logo_alt',
                'site_favicon_alt',
                'profile_one_alt',
                'profile_two_alt',
            ]);
        });

        Schema::dropIfExists('seo_settings');
    }
};
