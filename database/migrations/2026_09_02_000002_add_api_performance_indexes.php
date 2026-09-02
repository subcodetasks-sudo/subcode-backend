<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->index(['is_active', 'status']);
            $table->index(['category_id', 'is_active', 'status']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index(['status', 'department_id']);
            $table->index(['is_special', 'status']);
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->index(['status', 'department_id']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('success_numbers', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('occasions', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->index(['type', 'ip', 'user_agent']);
            $table->index(['visitable_type', 'visitable_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'status']);
            $table->dropIndex(['category_id', 'is_active', 'status']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['status', 'department_id']);
            $table->dropIndex(['is_special', 'status']);
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->dropIndex(['status', 'department_id']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('success_numbers', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('occasions', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->dropIndex(['type', 'ip', 'user_agent']);
            $table->dropIndex(['visitable_type', 'visitable_id', 'type']);
        });
    }
};
