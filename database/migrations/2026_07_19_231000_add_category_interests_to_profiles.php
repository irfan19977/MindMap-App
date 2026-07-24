<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->json('category_interests')->nullable()->after('learning_interest');
        });

        Schema::table('umum_users', function (Blueprint $table) {
            $table->json('category_interests')->nullable()->after('learning_interest');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('category_interests');
        });

        Schema::table('umum_users', function (Blueprint $table) {
            $table->dropColumn('category_interests');
        });
    }
};
