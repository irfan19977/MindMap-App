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
        Schema::table('class_material', function (Blueprint $table) {
            // Drop the auto-generated id column so Laravel can sync without a primary key value.
            $table->dropColumn('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_material', function (Blueprint $table) {
            $table->uuid('id')->primary();
        });
    }
};
