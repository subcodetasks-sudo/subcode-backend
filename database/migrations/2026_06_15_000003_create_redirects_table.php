<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('resource_type', 64);
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->string('source_locale', 2);
            $table->string('source_slug');
            $table->string('source_path', 2048);
            $table->unsignedSmallInteger('status_code');
            $table->string('target_slug')->nullable();
            $table->string('target_path', 2048)->nullable();
            $table->string('target_locale', 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->unique(['source_locale', 'source_path'], 'redirects_locale_source_path_unique');
            $table->index(['resource_type', 'status_code', 'is_active']);
            $table->index('source_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
