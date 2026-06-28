<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'quiz_id',
        'question',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'order_number',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
        'order_number' => 'integer',
    ];

    /**
     * Get the quiz that owns the question.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the quiz answers for the question.
     */
    public function quizAnswers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    /**
     * Scope a query to order by order number.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }
}
