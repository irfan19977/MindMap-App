<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix created_by on categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->uuid('created_by_new')->nullable()->after('created_by');
            $table->foreign('created_by_new')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement('UPDATE categories SET created_by_new = created_by WHERE created_by IS NOT NULL AND created_by REGEXP \'[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\'');
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('created_by_new', 'created_by');
        });

        // Fix created_by on subcategories table
        Schema::table('subcategories', function (Blueprint $table) {
            $table->uuid('created_by_new')->nullable()->after('created_by');
            $table->foreign('created_by_new')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement('UPDATE subcategories SET created_by_new = created_by WHERE created_by IS NOT NULL AND created_by REGEXP \'[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\'');
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('subcategories', function (Blueprint $table) {
            $table->renameColumn('created_by_new', 'created_by');
        });

        // Fix created_by on materials table
        Schema::table('materials', function (Blueprint $table) {
            $table->uuid('created_by_new')->nullable()->after('created_by');
            $table->foreign('created_by_new')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement('UPDATE materials SET created_by_new = created_by WHERE created_by IS NOT NULL AND created_by REGEXP \'[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\'');
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->renameColumn('created_by_new', 'created_by');
        });

        // Fix created_by on mindmaps table + add reference_type for polymorphic
        Schema::table('mindmaps', function (Blueprint $table) {
            $table->string('reference_type')->nullable()->after('reference_id');
            $table->uuid('created_by_new')->nullable()->after('created_by');
            $table->foreign('created_by_new')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement('UPDATE mindmaps SET created_by_new = created_by WHERE created_by IS NOT NULL AND created_by REGEXP \'[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\'');
        Schema::table('mindmaps', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('mindmaps', function (Blueprint $table) {
            $table->renameColumn('created_by_new', 'created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert mindmaps
        Schema::table('mindmaps', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['created_by', 'reference_type']);
            $table->string('created_by')->nullable();
        });

        // Revert materials
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
            $table->string('created_by')->nullable();
        });

        // Revert subcategories
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
            $table->string('created_by')->nullable();
        });

        // Revert categories
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
            $table->string('created_by')->nullable();
        });
    }
};
