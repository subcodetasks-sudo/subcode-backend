<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('profile_one')->nullable();
            $table->string('profile_two')->nullable();
            $table->boolean('web_site_toggle')->default(true);
            $table->boolean('home_page_toggle')->default(true);
            $table->boolean('about_page_toggle')->default(true);
            $table->boolean('our_services_toggle')->default(true);
            $table->boolean('our_projects_toggle')->default(true);
            $table->boolean('packages_toggle')->default(true);
            $table->boolean('our_products_toggle')->default(true);
            $table->boolean('blogs_toggle')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('profile_one');
            $table->dropColumn('profile_two');
            $table->dropColumn('web_site_toggle');
            $table->dropColumn('home_page_toggle');
            $table->dropColumn('about_page_toggle');
            $table->dropColumn('our_services_toggle');
            $table->dropColumn('our_projects_toggle');
            $table->dropColumn('packages_toggle');
            $table->dropColumn('our_products_toggle');
            $table->dropColumn('blogs_toggle');
        });
    }
};
