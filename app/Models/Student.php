<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Student extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'school',
        'grade',
        'major',
        'learning_interest',
        'birth_date',
        'phone',
        'address',
        'avatar',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class);
    }

    public function courseClasses()
    {
        return $this->belongsToMany(CourseClass::class, 'class_enrollments', 'student_id', 'class_id')
            ->withPivot('status', 'progress_percentage', 'enrolled_at', 'completed_at', 'approved_at', 'notes')
            ->wherePivot('status', '!=', 'dropped');
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? '';
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? '';
    }

    /**
     * Get the public URL of the student's avatar, if any.
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    /**
     * Get course classes where the student is actively enrolled.
     */
    public function getEnrolledCoursesAttribute(): Collection
    {
        return $this->courseClasses()
            ->with(['category', 'subcategory', 'teacher.user', 'materials'])
            ->wherePivotIn('status', ['active', 'completed'])
            ->get();
    }

    /**
     * Get total completed materials count.
     */
    public function getCompletedMaterialsCountAttribute(): int
    {
        return UserProgress::where('user_id', $this->user_id)
            ->whereNotNull('completed_at')
            ->count();
    }

    /**
     * Get total materials in progress count.
     */
    public function getInProgressMaterialsCountAttribute(): int
    {
        return UserProgress::where('user_id', $this->user_id)
            ->whereNull('completed_at')
            ->count();
    }

    /**
     * Get quiz attempts for this student.
     */
    public function getQuizAttemptsCountAttribute(): int
    {
        return \App\Models\QuizAttempt::where('user_id', $this->user_id)->count();
    }

    /**
     * Get passed quiz count.
     */
    public function getPassedQuizCountAttribute(): int
    {
        return \App\Models\QuizAttempt::where('user_id', $this->user_id)
            ->where('status', 'passed')
            ->count();
    }
}