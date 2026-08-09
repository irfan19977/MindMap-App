<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'class_id',
        'student_id',
        'status',
        'enrolled_at',
        'completed_at',
        'approved_at',
        'approved_by',
        'progress_percentage',
        'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'approved_at' => 'datetime',
        'progress_percentage' => 'decimal:2',
    ];

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function syncProgress()
    {
        $percentage = $this->courseClass->getProgressForStudent($this->student_id);
        $this->progress_percentage = $percentage;

        if ($percentage >= 100 && is_null($this->completed_at)) {
            $this->completed_at = now();
        }

        $this->save();

        return $this;
    }

    public function getCompletedMaterialsCountAttribute()
    {
        if (!$this->courseClass) {
            return 0;
        }

        $materialIds = $this->courseClass->materials()->pluck('materials.id');
        
        if ($materialIds->isEmpty()) {
            return 0;
        }

        $student = $this->student;
        if (!$student) {
            return 0;
        }

        // Get materials completed through UserProgress
        $progressCompleted = \App\Models\UserProgress::where('user_id', $student->user_id)
            ->whereIn('material_id', $materialIds)
            ->whereNotNull('completed_at')
            ->pluck('material_id')
            ->toArray();

        // Get materials completed through passed quizzes
        $quizCompleted = \App\Models\QuizAttempt::where('user_id', $student->user_id)
            ->where('status', 'passed')
            ->with('quiz:id,material_id')
            ->get()
            ->pluck('quiz.material_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Merge both completion methods and ensure uniqueness
        $allCompletedMaterialIds = array_unique(array_merge($progressCompleted, $quizCompleted));
        
        // Count only materials that are actually in this class
        return count(array_intersect($allCompletedMaterialIds, $materialIds->toArray()));
    }
}
