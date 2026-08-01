<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLoginHistory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'login_date',
        'logged_in_at',
        'streak_count',
        'xp_earned',
    ];

    protected $casts = [
        'login_date' => 'date',
        'logged_in_at' => 'datetime',
        'streak_count' => 'integer',
        'xp_earned' => 'integer',
    ];

    /**
     * Get the user that owns the login history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
