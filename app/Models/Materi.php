<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Materi extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'video_url',
        'file_path',
        'thumbnail',
        'category_id',
        'difficulty_level',
        'duration_minutes',
        'status',
        'is_featured',
        'is_free',
        'order_number',
        'tags',
        'view_count',
        'konten_materi',
        'latihan_data',
        'quiz_data',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_free' => 'boolean',
        'order_number' => 'integer',
        'duration_minutes' => 'integer',
        'view_count' => 'integer',
        'tags' => 'array',
        'konten_materi' => 'array',
        'latihan_data' => 'array',
        'quiz_data' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($materi) {
            if (empty($materi->slug)) {
                $materi->slug = Str::slug($materi->title);
            }
        });

        static::updating(function ($materi) {
            if ($materi->isDirty('title') && empty($materi->slug)) {
                $materi->slug = Str::slug($materi->title);
            }
        });
    }

    /**
     * Get the category that owns the materi.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the parent category if this materi belongs to a child category.
     */
    public function getParentCategoryAttribute()
    {
        return $this->category?->parent;
    }

    /**
     * Get the full category breadcrumb.
     */
    public function getCategoryBreadcrumbAttribute()
    {
        if (!$this->category) {
            return null;
        }
        
        return $this->category->breadcrumb;
    }

    /**
     * Get the root category of this materi.
     */
    public function getRootCategoryAttribute()
    {
        if (!$this->category) {
            return null;
        }
        
        $breadcrumb = $this->category->breadcrumb;
        return $breadcrumb[0] ?? null;
    }

    /**
     * Scope a query to only include materis from specific category or its children.
     */
    public function scopeInCategoryOrChildren($query, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return $query;
        }
        
        $categoryIds = $category->recursiveChildren()->pluck('id')->push($categoryId);
        return $query->whereIn('category_id', $categoryIds);
    }

    /**
     * Scope a query to only include published materis.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include featured materis.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include free materis.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope a query to filter by difficulty level.
     */
    public function scopeDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope a query to order by order number and title.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number', 'asc')->orderBy('title', 'asc');
    }

    /**
     * Get the formatted difficulty level.
     */
    public function getFormattedDifficultyLevelAttribute()
    {
        return match($this->difficulty_level) {
            'beginner' => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced' => 'Lanjutan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'published' => 'Diterbitkan',
            'archived' => 'Diarsipkan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        return asset('backend/assets/images/default-materi.jpg');
    }

    /**
     * Get the file URL.
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        return null;
    }

    /**
     * Increment view count.
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
