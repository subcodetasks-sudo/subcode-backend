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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
                   $table->string('site_name')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_email')->nullable();
            $table->string('site_phone')->nullable();
            $table->text('site_address')->nullable();
            
            // Social Media Links
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            
            // Legal Pages
            $table->longText('terms_conditions')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('refund_policy')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('contact_info')->nullable();
            
            // SEO Settings
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('google_analytics')->nullable();
            $table->string('facebook_pixel')->nullable();
            
            // Additional Settings
            $table->string('currency')->default('USD')->nullable();
            $table->string('timezone')->default('UTC')->nullable();
            $table->string('language')->default('en')->nullable();
            $table->boolean('maintenance_mode')->default(false);

             $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
