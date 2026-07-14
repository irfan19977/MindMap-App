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

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($quizAttempt) {
            // Sync progress when quiz attempt status changes to 'passed'
            if ($quizAttempt->wasChanged('status') && $quizAttempt->status === 'passed') {
                $quizAttempt->syncStudentProgress();
            }
        });

        static::created(function ($quizAttempt) {
            // Sync progress when quiz attempt is created with 'passed' status
            if ($quizAttempt->status === 'passed') {
                $quizAttempt->syncStudentProgress();
            }
        });
    }

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

    /**
     * Sync student progress for all class enrollments when quiz is passed
     */
    public function syncStudentProgress()
    {
        if (!$this->quiz || !$this->quiz->material_id) {
            return;
        }

        // Find all classes that contain this material
        $classes = CourseClass::whereHas('materials', function ($query) {
            $query->where('materials.id', $this->quiz->material_id);
        })->get();

        // Find the student record for this user
        $student = Student::where('user_id', $this->user_id)->first();
        if (!$student) {
            return;
        }

        // Sync progress for each class enrollment
        foreach ($classes as $class) {
            $enrollment = ClassEnrollment::where('class_id', $class->id)
                ->where('student_id', $student->id)
                ->first();

            if ($enrollment) {
                $enrollment->syncProgress();
            }
        }
    }
}
