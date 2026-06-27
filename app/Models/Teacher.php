<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'specialization',
        'category',
        'description',
        'education',
        'experience',
        'image_url',
        'rating',
        'review_count',
        'linkedin_url',
        'twitter_url',
        'github_url',
        'email',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'review_count' => 'integer',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function publishedCourses(): HasMany
    {
        return $this->hasMany(Course::class)->where('is_published', true);
    }
}
