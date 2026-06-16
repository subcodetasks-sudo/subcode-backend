<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('slug')->nullable()->after('title');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->text('slug')->nullable()->after('name');
        });

        Schema::table('occasions', function (Blueprint $table) {
            $table->text('slug')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('occasions', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
