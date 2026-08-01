<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\UserProgress;

class Student extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'school',
        'grade',
        'major',
        'learning_interest',
        'category_interests',
        'birth_date',
        'phone',
        'address',
        'avatar',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'category_interests' => 'array',
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
        return count($this->getCompletedMaterialIds());
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
     * Get the list of unique completed material IDs.
     */
    public function getCompletedMaterialIds(): array
    {
        $quizMaterialIds = \App\Models\QuizAttempt::where('user_id', $this->user_id)
            ->where('status', 'passed')
            ->with('quiz:id,material_id')
            ->get()
            ->pluck('quiz.material_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $progressMaterialIds = UserProgress::where('user_id', $this->user_id)
            ->whereNotNull('completed_at')
            ->pluck('material_id')
            ->unique()
            ->values()
            ->toArray();

        return array_unique(array_merge($quizMaterialIds, $progressMaterialIds));
    }

    /**
     * Get total experience points for the student.
     */
    public function getExperiencePointsAttribute(): int
    {
        $completedMaterialsXP = count($this->getCompletedMaterialIds()) * 100;
        $passedQuizXP = $this->passed_quiz_count * 25;
        
        // XP from practice exercises (latihan)
        $practiceXP = \App\Models\PracticeAnswer::where('user_id', $this->user_id)
            ->where('is_correct', true)
            ->sum('points_earned');
        
        // XP from daily login streak
        $streakXP = $this->calculateStreakXP();
        
        return $completedMaterialsXP + $passedQuizXP + $practiceXP + $streakXP;
    }

    /**
     * Calculate XP from daily login streak.
     */
    private function calculateStreakXP(): int
    {
        $user = \App\Models\User::find($this->user_id);
        if (!$user || !$user->last_login_at) {
            return 0;
        }

        // Get the most recent login history for this user
        $latestLogin = \App\Models\UserLoginHistory::where('user_id', $this->user_id)
            ->orderBy('login_date', 'desc')
            ->first();

        if (!$latestLogin) {
            return 0;
        }

        $streakDays = $latestLogin->streak_count;
        
        // XP reward based on streak
        return match (true) {
            $streakDays >= 30 => 500,  // 30+ days streak
            $streakDays >= 14 => 300,  // 14+ days streak
            $streakDays >= 7 => 150,   // 7+ days streak
            $streakDays >= 3 => 75,    // 3+ days streak
            default => 25,              // Daily login
        };
    }

    /**
     * Get level name based on experience points.
     */
    public function getLevelAttribute(): string
    {
        $xp = $this->experience_points;

        return match (true) {
            $xp >= 10000 => 'Future Leader',
            $xp >= 8000 => 'Master Mind',
            $xp >= 5500 => 'Expert Learner',
            $xp >= 3500 => 'Smart Achiever',
            $xp >= 2000 => 'Rising Scholar',
            $xp >= 1000 => 'Knowledge Seeker',
            $xp >= 500 => 'Active Learner',
            default => 'New Explorer',
        };
    }

    /**
     * Get current progress toward the next level.
     */
    public function getLevelProgressAttribute(): int
    {
        [$min, $max] = $this->getLevelRange();

        if ($max === null) {
            return 100;
        }

        $progress = ($this->experience_points - $min) / max(1, $max - $min);
        return (int) floor(min(100, max(0, $progress * 100)));
    }

    /**
     * Get how much XP is needed to reach the next level.
     */
    public function getExperienceToNextLevelAttribute(): ?int
    {
        [, $max] = $this->getLevelRange();

        if ($max === null) {
            return null;
        }

        return max(0, $max - $this->experience_points);
    }

    private function getLevelRange(): array
    {
        $xp = $this->experience_points;

        return match (true) {
            $xp >= 10000 => [10000, null],
            $xp >= 8000 => [8000, 9999],
            $xp >= 5500 => [5500, 7999],
            $xp >= 3500 => [3500, 5499],
            $xp >= 2000 => [2000, 3499],
            $xp >= 1000 => [1000, 1999],
            $xp >= 500 => [500, 999],
            default => [0, 499],
        };
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