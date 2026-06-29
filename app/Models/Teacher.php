<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Material;
use App\Models\Mindmap;
use App\Models\Subcategory;

class Teacher extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
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
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'review_count' => 'integer',
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

    public function getPublishedCoursesAttribute(): Collection
    {
        return Subcategory::where('created_by', $this->user_id)
            ->where('status', 'publish')
            ->get();
    }

    public function categories()
    {
        return Category::where('created_by', $this->user_id)->get();
    }

    public function materials()
    {
        return Material::where('created_by', $this->user_id)->get();
    }

    public function mindmaps()
    {
        return Mindmap::where('created_by', $this->user_id)->get();
    }
}
