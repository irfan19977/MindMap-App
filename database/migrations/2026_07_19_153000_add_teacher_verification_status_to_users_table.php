<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('teacher_verification_status')->nullable()->after('is_active');
        });

        DB::table('users')
            ->where('user_type', 'teacher')
            ->where('is_active', true)
            ->update(['teacher_verification_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('teacher_verification_status');
        });
    }
};
