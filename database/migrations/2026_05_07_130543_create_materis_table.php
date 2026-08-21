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
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('learning_objectives')->nullable();
            $table->longText('content')->nullable();
            $table->enum('status', ['publish', 'draft', 'inactive'])->default('draft');
            $table->boolean('is_free')->default(true);
            $table->json('latihan_data')->nullable();
            $table->json('quiz_data')->nullable();
            $table->integer('order_number')->default(0);
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes untuk performance
            $table->unique(['slug', 'created_by']);
            $table->index('slug');
            $table->index('subcategory_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
