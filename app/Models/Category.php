<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'status',
        'is_featured',
        'created_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the subcategories for this category.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Get the children for this category (alias for subcategories).
     */
    public function children()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Get all materials under this category (alias for materials).
     */
    public function materis(): HasManyThrough
    {
        return $this->hasManyThrough(Material::class, Subcategory::class, 'category_id', 'subcategory_id', 'id', 'id');
    }

    /**
     * Get the course classes for this category.
     */
    public function courseClasses()
    {
        return $this->hasMany(CourseClass::class);
    }

    /**
     * Scope a query to only include published categories.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    /**
     * Scope a query to only include featured categories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Get formatted grade level (from first subcategory if exists).
     */
    public function getFormattedGradeLevelAttribute(): string
    {
        if ($this->children && $this->children->first()) {
            return $this->children->first()->formatted_grade_level;
        }
        return 'Umum';
    }

    /**
     * Get grade level (from first subcategory if exists).
     */
    public function getGradeLevelAttribute(): string
    {
        if ($this->children && $this->children->first()) {
            return $this->children->first()->grade_level;
        }
        return 'umum';
    }

    /**
     * Get curriculum (from first subcategory if exists).
     */
    public function getCurriculumAttribute()
    {
        if ($this->children && $this->children->first()) {
            return $this->children->first()->curriculum;
        }
        return null;
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        
        return asset('backend/assets/images/default-cover.jpg');
    }
}
