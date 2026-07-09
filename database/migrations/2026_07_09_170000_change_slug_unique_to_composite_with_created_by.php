<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Drop global unique on slug, replace with composite unique(slug, created_by)
     * so different users can have the same slug.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->unique(['slug', 'created_by']);
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->unique(['slug', 'created_by']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->unique(['slug', 'created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['slug', 'created_by']);
            $table->unique(['slug']);
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropUnique(['slug', 'created_by']);
            $table->unique(['slug']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropUnique(['slug', 'created_by']);
            $table->unique(['slug']);
        });
    }
};
