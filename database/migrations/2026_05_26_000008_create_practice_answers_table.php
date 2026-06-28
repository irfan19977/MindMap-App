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
        Schema::create('practice_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('practice_question_id');
            $table->foreign('practice_question_id')->references('id')->on('practice_questions')->onDelete('cascade');
            $table->text('user_answer');
            $table->boolean('is_correct');
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index('user_id');
            $table->index('practice_question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_answers');
    }
};
