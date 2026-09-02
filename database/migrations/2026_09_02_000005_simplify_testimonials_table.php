<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('client_image', 'media');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn([
                'client_name',
                'description',
                'project_name',
                'project_image',
                'client_image_alt',
                'project_image_alt',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('client_name')->after('id');
            $table->text('description')->after('client_name');
            $table->string('project_image')->nullable()->after('media');
            $table->string('project_name')->after('project_image');
            $table->text('client_image_alt')->nullable();
            $table->text('project_image_alt')->nullable();
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('media', 'client_image');
        });
    }
};
