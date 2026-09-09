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
        Schema::table('user_login_histories', function (Blueprint $table) {
            // Drop the existing unique constraint on login_date only
            $table->dropUnique('user_login_histories_login_date_unique');
            
            // Add composite unique constraint on user_id and login_date
            $table->unique(['user_id', 'login_date'], 'user_login_histories_user_id_login_date_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_login_histories', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('user_login_histories_user_id_login_date_unique');
            
            // Restore the unique constraint on login_date only
            $table->unique('login_date', 'user_login_histories_login_date_unique');
        });
    }
};
