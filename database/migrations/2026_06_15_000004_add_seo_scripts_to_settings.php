<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('custom_head_scripts')->nullable()->after('facebook_app_id');
            $table->text('custom_body_scripts')->nullable()->after('custom_head_scripts');
            $table->text('robots_txt')->nullable()->after('custom_body_scripts');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['custom_head_scripts', 'custom_body_scripts', 'robots_txt']);
        });
    }
};
