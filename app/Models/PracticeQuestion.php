<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeQuestion extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'material_id',
        'question',
        'question_type',
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
     * Get the material that owns the practice question.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the practice answers for the question.
     */
    public function practiceAnswers(): HasMany
    {
        return $this->hasMany(PracticeAnswer::class);
    }

    /**
     * Scope a query to order by order number.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }
}
