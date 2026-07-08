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
            $table->string('user_type')->nullable()->after('email_verified_at');
            $table->boolean('is_active')->default(true)->after('user_type');
        });

        // Backfill user_type from existing Spatie roles.
        foreach (\App\Models\User::with('roles')->cursor() as $user) {
            $role = $user->roles->first()?->name;

            $userType = match ($role) {
                'admin' => 'admin',
                'teacher' => 'teacher',
                'student' => 'student',
                default => 'student',
            };

            $user->user_type = $userType;
            $user->is_active = true;
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'is_active']);
        });
    }
};
