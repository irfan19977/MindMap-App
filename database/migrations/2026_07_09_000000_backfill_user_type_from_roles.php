<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (\App\Models\User::with('roles')->cursor() as $user) {
            if (! empty($user->user_type)) {
                continue;
            }

            $role = $user->roles->first()?->name;

            $userType = match ($role) {
                'admin'   => 'admin',
                'teacher' => 'teacher',
                default   => 'student',
            };

            DB::table('users')
                ->where('id', $user->id)
                ->update(['user_type' => $userType]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left blank: we cannot safely undo a backfill.
    }
};
