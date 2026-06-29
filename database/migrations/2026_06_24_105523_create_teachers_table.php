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
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('specialization');
            $table->enum('category', ['akademik', 'digital', 'bisnis'])->nullable();
            $table->text('description')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('github_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
