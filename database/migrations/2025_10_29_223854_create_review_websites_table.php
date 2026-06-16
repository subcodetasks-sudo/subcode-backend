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
        Schema::create('review_websites', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->text('project_name');
            $table->string('project_image');
            $table->foreignId('website_id')->constrained('websites')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_websites');
    }
};
