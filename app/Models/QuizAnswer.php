<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'quiz_attempt_id',
        'quiz_question_id',
        'user_answer',
        'is_correct',
        'points_earned',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
        'user_answer' => 'string',
    ];

    /**
     * Get the quiz attempt that owns the answer.
     */
    public function quizAttempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    /**
     * Get the quiz question that owns the answer.
     */
    public function quizQuestion(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    /**
     * Get the quiz question that owns the answer (alias for convenience).
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}
