<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Admin extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'slug',
        'description',
        'specialization',
        'category',
        'education',
        'experience',
        'company',
        'date_of_birth',
        'country',
        'city',
        'image_url',
        'rating',
        'review_count',
        'linkedin_url',
        'youtube_url',
        'github_url',
        'instagram',
        'facebook',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
