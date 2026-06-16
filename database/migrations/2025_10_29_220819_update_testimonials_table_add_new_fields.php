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
        Schema::table('testimonials', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('name', 'client_name');
            $table->renameColumn('comment', 'description');
            $table->renameColumn('image', 'client_image');
        });
        
        Schema::table('testimonials', function (Blueprint $table) {
            // Add new columns
            $table->string('project_image')->nullable()->after('client_image');
            $table->string('project_name')->after('project_image');
            
            // Drop rating column as it's not needed in new structure
            $table->dropColumn('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Add back rating column
            $table->decimal('rating', 3, 1)->default(0.0);
            
            // Drop new columns
            $table->dropColumn(['project_image', 'project_name']);
        });
        
        Schema::table('testimonials', function (Blueprint $table) {
            // Rename columns back
            $table->renameColumn('client_name', 'name');
            $table->renameColumn('description', 'comment');
            $table->renameColumn('client_image', 'image');
        });
    }
};
