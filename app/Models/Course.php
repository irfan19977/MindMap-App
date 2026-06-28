<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'slug',
        'description',
        'level',
        'duration_hours',
        'price',
        'thumbnail_url',
        'enrollment_count',
        'rating',
        'review_count',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'enrollment_count' => 'integer',
        'review_count' => 'integer',
        'duration_hours' => 'integer',
        'price' => 'integer',
        'is_published' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
