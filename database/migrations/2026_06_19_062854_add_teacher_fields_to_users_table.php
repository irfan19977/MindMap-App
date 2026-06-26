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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('school')->nullable()->after('phone');
            $table->string('subject')->nullable()->after('school');
            $table->string('address')->nullable()->after('subject');
            $table->enum('user_type', ['admin', 'teacher', 'student'])->default('student')->after('address');
            $table->boolean('is_active')->default(true)->after('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'school', 'subject', 'address', 'user_type', 'is_active']);
        });
    }
};
