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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('grade_level', ['sd', 'smp', 'sma', 'umum']);
            $table->longText('curriculum')->nullable();
            $table->enum('status', ['publish', 'draft', 'inactive'])->default('draft');
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index('slug');
            $table->index('category_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
