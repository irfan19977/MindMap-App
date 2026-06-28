<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'theme_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'theme_preferences' => 'array',
        ];
    }

    /**
     * Get the user's progress records.
     */
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Get the user's quiz attempts.
     */
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get the user's practice answers.
     */
    public function practiceAnswers()
    {
        return $this->hasMany(PracticeAnswer::class);
    }

    /**
     * Get overall progress percentage for a user.
     */
    public function getOverallProgressAttribute()
    {
        $totalMaterials = Material::count();
        if ($totalMaterials === 0) return 0;

        $completedMaterials = $this->userProgress()->whereNotNull('completed_at')->count();
        return round(($completedMaterials / $totalMaterials) * 100, 2);
    }

    /**
     * Get average quiz score for a user.
     */
    public function getAverageQuizScoreAttribute()
    {
        $completedQuizzes = $this->quizAttempts()->where('status', 'passed');
        if ($completedQuizzes->count() === 0) return 0;

        return round($completedQuizzes->avg('score'), 2);
    }
}
