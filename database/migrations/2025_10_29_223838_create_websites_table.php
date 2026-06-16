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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('slug');
            $table->text('caption');
            $table->string('main_image');
            $table->text('images');
            $table->text('description');
            $table->json('tags');
            $table->string('link_website')->nullable();
            $table->longText('long_description');
            $table->longText('technologies');
            $table->boolean('status')->default(true);
            $table->boolean('is_special')->default(false);
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
