<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('metas', function (Blueprint $table) {
            $table->text('og_title')->nullable()->after('meta_description');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('og_type')->nullable()->after('og_image');
            $table->string('twitter_card')->nullable()->after('og_type');
            $table->text('twitter_title')->nullable()->after('twitter_card');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
        });

        Schema::table('seo_settings', function (Blueprint $table) {
            $table->text('og_title')->nullable()->after('meta_description');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('og_type')->nullable()->after('og_image');
            $table->string('twitter_card')->nullable()->after('og_type');
            $table->text('twitter_title')->nullable()->after('twitter_card');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('og_default_image')->nullable()->after('home_meta_description');
            $table->string('twitter_site')->nullable()->after('og_default_image');
            $table->string('twitter_card_default')->nullable()->after('twitter_site');
            $table->string('facebook_app_id')->nullable()->after('twitter_card_default');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'og_default_image',
                'twitter_site',
                'twitter_card_default',
                'facebook_app_id',
            ]);
        });

        Schema::table('seo_settings', function (Blueprint $table) {
            $table->dropColumn([
                'og_title',
                'og_description',
                'og_image',
                'og_type',
                'twitter_card',
                'twitter_title',
                'twitter_description',
                'twitter_image',
            ]);
        });

        Schema::table('metas', function (Blueprint $table) {
            $table->dropColumn([
                'og_title',
                'og_description',
                'og_image',
                'og_type',
                'twitter_card',
                'twitter_title',
                'twitter_description',
                'twitter_image',
            ]);
        });
    }
};
