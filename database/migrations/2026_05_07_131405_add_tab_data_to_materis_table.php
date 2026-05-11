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
        Schema::table('materis', function (Blueprint $table) {
            $table->json('konten_materi')->nullable()->after('content');
            $table->json('latihan_data')->nullable()->after('konten_materi');
            $table->json('quiz_data')->nullable()->after('latihan_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropColumn(['konten_materi', 'latihan_data', 'quiz_data']);
        });
    }
};
