<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'practice_question_id',
        'user_answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the user that owns the answer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the practice question that owns the answer.
     */
    public function practiceQuestion(): BelongsTo
    {
        return $this->belongsTo(PracticeQuestion::class);
    }
}
