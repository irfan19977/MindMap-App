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
        'birth_date',
        'phone',
        'address',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Get subcategories (kelas) where the student has progress on materials.
     */
    public function getEnrolledCoursesAttribute(): Collection
    {
        $materialIds = UserProgress::where('user_id', $this->user_id)
            ->pluck('material_id')
            ->unique();

        if ($materialIds->isEmpty()) {
            return collect();
        }

        $subcategoryIds = Material::whereIn('id', $materialIds)
            ->pluck('subcategory_id')
            ->unique();

        return Subcategory::whereIn('id', $subcategoryIds)
            ->with('category')
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
