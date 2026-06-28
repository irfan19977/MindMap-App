<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizAttempt extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_points',
        'earned_points',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'total_points' => 'integer',
        'earned_points' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that owns the attempt.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the quiz answers for the attempt.
     */
    public function quizAnswers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
