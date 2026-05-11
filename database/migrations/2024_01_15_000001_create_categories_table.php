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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('curriculum')->nullable();
            $table->string('cover_image')->nullable();
            
            // Foreign key untuk parent category
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            
            // Fields untuk kelas pembelajaran
            $table->enum('grade_level', ['sd', 'smp', 'sma', 'umum'])->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Fields untuk sorting dan display
            $table->integer('order_number')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_free')->default(true);
            
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index(['status', 'is_featured']);
            $table->index(['grade_level', 'status']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
