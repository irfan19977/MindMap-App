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
        Schema::create('teacher_collaborations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('admin_id'); // User who created the invitation (admin)
            $table->uuid('teacher_id'); // Teacher being invited
            $table->uuid('category_id')->nullable(); // Category for collaboration
            $table->uuid('subcategory_id')->nullable(); // Subcategory for collaboration
            $table->uuid('class_id')->nullable(); // Specific class for collaboration
            $table->string('collaboration_type'); // 'category', 'subcategory', 'class'
            $table->text('message')->nullable(); // Invitation message
            $table->enum('status', ['pending', 'accepted', 'rejected', 'revoked'])->default('pending');
            $table->json('permissions')->nullable(); // Specific permissions granted
            $table->timestamp('invited_at');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

            // Indexes
            $table->index(['teacher_id', 'status']);
            $table->index(['admin_id', 'status']);
            $table->index(['collaboration_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_collaborations');
    }
};
