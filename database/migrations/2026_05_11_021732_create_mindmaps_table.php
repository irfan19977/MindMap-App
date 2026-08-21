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
        Schema::create('mindmaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('reference_id'); // Can be category_id or subcategory_id
            $table->string('reference_type')->nullable(); // For polymorphic relationship
            $table->string('title');
            $table->json('structure')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['publish', 'draft', 'inactive'])->default('draft');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();

            // Indexes untuk performance
            $table->index('reference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mindmaps');
    }
};
