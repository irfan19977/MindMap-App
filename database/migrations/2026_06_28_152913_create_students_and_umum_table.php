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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('school')->nullable();
            $table->string('grade')->nullable();
            $table->string('major')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->text('learning_interest')->nullable();
            $table->json('category_interests')->nullable();
            $table->timestamps();
        });

        Schema::create('umum_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('occupation')->nullable();
            $table->text('address')->nullable();
            $table->text('learning_interest')->nullable();
            $table->json('category_interests')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('umum_users');
    }
};
